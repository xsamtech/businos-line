<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Gain;
use App\Models\Payment;
use App\Models\Saving;
use App\Services\PayPalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PayPalController extends Controller
{
    public function __construct(private PayPalService $paypal) {}

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate(['amount' => ['required', 'numeric', 'min:1', 'max:999999.99']]);
        $reference = (string) Str::uuid();
        $order = $this->paypal->createOrder(number_format((float) $data['amount'], 2, '.', ''), 'EUR', $reference);
        Payment::create(['reference' => $reference, 'provider' => 'paypal', 'provider_reference' => $order['id'], 'amount' => $data['amount'], 'currency' => 'EUR', 'reason' => 'save', 'entity' => 'saving', 'status' => 0, 'user_id' => $request->user()->id]);
        $approval = collect($order['links'] ?? [])->firstWhere('rel', 'approve');

        return response()->json(['redirect_url' => $approval['href'] ?? null]);
    }

    public function returned(Request $request): RedirectResponse
    {
        $this->paypal->capture((string) $request->query('token'));

        return redirect()->route('savings')->with('success', __('messages.payment_processing'));
    }

    public function canceled(): RedirectResponse
    {
        return redirect()->route('savings')->with('error', __('messages.payment_canceled'));
    }

    public function webhook(Request $request): JsonResponse
    {
        $headers = ['paypal-auth-algo' => $request->header('paypal-auth-algo'), 'paypal-cert-url' => $request->header('paypal-cert-url'), 'paypal-transmission-id' => $request->header('paypal-transmission-id'), 'paypal-transmission-sig' => $request->header('paypal-transmission-sig'), 'paypal-transmission-time' => $request->header('paypal-transmission-time')];
        abort_unless($this->paypal->verifyWebhook($headers, $request->all()), 400, 'Invalid PayPal signature');
        $event = $request->all();
        $providerReference = data_get($event, 'resource.supplementary_data.related_ids.order_id') ?? data_get($event, 'resource.id');
        $senderReference = data_get($event, 'resource.payout_item.sender_item_id');
        $payment = Payment::query()->where('provider_reference', $providerReference)->when($senderReference, fn ($query) => $query->orWhere('reference', $senderReference))->first();
        if (! $payment) {
            return response()->json(['received' => true]);
        }
        DB::transaction(function () use ($payment, $event): void {
            $completed = str_contains((string) ($event['event_type'] ?? ''), 'COMPLETED');
            $payment->update(['status' => $completed ? 1 : -1]);
            if ($completed && $payment->reason === 'save') {
                $saving = Saving::firstOrCreate(['user_id' => $payment->user_id, 'month' => now()->month, 'year' => now()->year], ['amount' => $payment->amount, 'currency' => $payment->currency, 'is_saving_sent' => true]);
                $saving->update(['amount' => $payment->amount, 'is_saving_sent' => true]);
                AppNotification::create(['type' => 'payment_done', 'to_user_id' => $payment->user_id, 'payment_id' => $payment->id, 'saving_id' => $saving->id]);
            }
            if ($completed && $payment->reason === 'payoff') {
                $gain = Gain::find($payment->entity_id);
                $gain?->update(['is_gain_paid' => true, 'is_general_interest_paid' => true]);
                AppNotification::create(['type' => 'gain_obtained', 'to_user_id' => $payment->user_id, 'payment_id' => $payment->id, 'gain_id' => $gain?->id]);
            }
        });

        return response()->json(['received' => true]);
    }
}
