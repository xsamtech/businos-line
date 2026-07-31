<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockInactiveSavers
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && $user->status === 'active' && $user->created_at?->lte(now()->subMonthsNoOverflow(3))) {
            $missed = collect(range(1, 3))->every(function (int $monthsAgo) use ($user): bool {
                $month = now()->subMonthsNoOverflow($monthsAgo);

                return ! $user->savings()->where('year', $month->year)->where('month', $month->month)->where('is_saving_sent', true)->exists();
            });
            if ($missed) {
                $user->update(['status' => 'blocked']);
            }
        }
        abort_if($user?->status === 'blocked', 403, 'Votre compte est bloqué après trois mois sans épargne.');

        return $next($request);
    }
}
