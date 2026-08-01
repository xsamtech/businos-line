@extends('layouts.public')

@section('title', __('messages.notifications'))

@section('content')
    <section class="py-5"><div class="container"><h1 class="mb-4">{{ __('messages.notifications') }}</h1><div class="d-grid gap-3">
        @forelse($notifications as $notification)
            <a class="card border-0 shadow-sm text-decoration-none text-body notification-card" href="{{ $notification->targetUrl() }}"><div class="card-body d-flex align-items-start gap-3"><span class="notification-icon"><i class="bi {{ $notification->type === 'welcome_new_member' ? 'bi-stars' : ($notification->gain_id ? 'bi-trophy' : 'bi-wallet2') }}"></i></span><div class="flex-grow-1"><p class="mb-1">{{ __('messages.notification_'.$notification->type) }}</p><small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small></div><i class="bi bi-chevron-right text-muted"></i></div></a>
        @empty
            <div class="text-center text-muted py-5"><i class="bi bi-bell display-4"></i><p class="mt-3">{{ __('messages.no_notifications') }}</p></div>
        @endforelse
    </div></div></section>
@endsection
