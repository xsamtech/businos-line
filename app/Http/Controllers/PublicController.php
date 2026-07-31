<?php

namespace App\Http\Controllers;

use App\Models\AboutSubject;
use App\Models\AppNotification;
use App\Models\Saving;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home(): View
    {
        $months = Saving::query()->selectRaw('year, month, COUNT(DISTINCT user_id) contributors, SUM(amount) total')->where('is_saving_sent', true)->groupBy('year', 'month')->orderByDesc('year')->orderByDesc('month')->limit(12)->get();

        return view('public.home', compact('months'));
    }

    public function savings(Request $request): View
    {
        return view('public.savings', ['savings' => $request->user()->savings()->latest('year')->latest('month')->get()]);
    }

    public function gains(Request $request): View
    {
        return view('public.gains', ['gains' => $request->user()->gains()->latest('year')->latest('month')->get()]);
    }

    public function notifications(Request $request): View
    {
        return view('public.notifications', ['notifications' => AppNotification::query()->where('to_user_id', $request->user()->id)->latest()->get()]);
    }

    public function legal(int $position): View
    {
        $subject = AboutSubject::query()->where('is_available', true)->oldest()->with('titles.contents.dashes')->skip($position)->firstOrFail();

        return view('public.legal', compact('subject'));
    }
}
