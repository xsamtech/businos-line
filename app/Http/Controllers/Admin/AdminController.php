<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSubject;
use App\Models\AboutTitle;
use App\Models\Gain;
use App\Models\Payment;
use App\Models\Role;
use App\Models\Saving;
use App\Models\User;
use App\Services\PayPalService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct(private PayPalService $paypal) {}

    public function dashboard(): View
    {
        return view('admin.dashboard', ['activeUsers' => User::where('status', 'active')->count(), 'blockedUsers' => User::where('status', 'blocked')->count(), 'monthlyTotal' => Saving::where('year', now()->year)->where('month', now()->month)->sum('amount'), 'users' => User::latest()->limit(10)->get(), 'gains' => Gain::with('user')->latest()->limit(10)->get(), 'savings' => Saving::with('user')->latest()->limit(10)->get()]);
    }

    public function users(Request $request): View
    {
        $users = User::with('roles')->when($request->role, fn ($q, $role) => $q->whereHas('roles', fn ($r) => $r->where('slug', $role)))->latest()->paginate(20)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, User $user): JsonResponse
    {
        $data = $request->validate(['status' => ['required', 'in:pending,active,suspended,blocked,deleted']]);
        $user->update($data);

        return response()->json(['message' => 'État mis à jour.']);
    }

    public function roles(): View
    {
        return view('admin.resource', ['title' => 'Rôles', 'items' => Role::latest()->paginate(20), 'columns' => ['role_name' => 'Nom', 'role_description' => 'Description']]);
    }

    public function savings(): View
    {
        return view('admin.resource', ['title' => 'Épargnes', 'items' => Saving::with('user')->latest()->paginate(20), 'columns' => ['user.firstname' => 'Membre', 'amount' => 'Montant', 'month' => 'Mois', 'year' => 'Année']]);
    }

    public function gains(): View
    {
        return view('admin.resource', ['title' => 'Gains', 'items' => Gain::with('user')->latest()->paginate(20), 'columns' => ['user.firstname' => 'Membre', 'amount' => 'Montant', 'month' => 'Mois', 'year' => 'Année']]);
    }

    public function payGain(Gain $gain): JsonResponse
    {
        abort_if($gain->is_gain_paid || ! $gain->user, 422, 'Ce gain ne peut pas être envoyé.');
        $reference = (string) Str::uuid();
        $netAmount = number_format((float) $gain->amount * 0.9, 2, '.', '');
        $payout = $this->paypal->sendPayout($gain->user->email, $netAmount, $gain->currency, $reference);
        Payment::create(['reference' => $reference, 'provider' => 'paypal', 'provider_reference' => data_get($payout, 'batch_header.payout_batch_id'), 'amount' => $gain->amount, 'amount_customer' => $netAmount, 'currency' => $gain->currency, 'reason' => 'payoff', 'entity' => 'gain', 'entity_id' => $gain->id, 'status' => 0, 'user_id' => $gain->user_id]);

        return response()->json(['message' => 'Le versement PayPal a été initié.']);
    }

    public function abouts(Request $request): View
    {
        $subjects = AboutSubject::oldest()->get();
        $subject = AboutSubject::with('titles.contents.dashes')->find($request->integer('subject')) ?? $subjects->first();

        return view('admin.abouts', compact('subjects', 'subject'));
    }

    public function search(Request $request): JsonResponse
    {
        $term = $request->string('q')->trim()->toString();

        return response()->json(['Utilisateurs' => User::where('email', 'like', "%{$term}%")->limit(5)->get()->map(fn ($u) => ['label' => trim("{$u->firstname} {$u->lastname}").' — '.$u->email, 'url' => route('admin.users')]), 'Rôles' => Role::where('slug', 'like', "%{$term}%")->limit(5)->get()->map(fn ($r) => ['label' => $r->role_name, 'url' => route('admin.roles')]), 'Titres' => AboutTitle::where('title', 'like', "%{$term}%")->limit(5)->get()->map(fn ($t) => ['label' => $t->title, 'url' => route('admin.abouts')])]);
    }
}
