@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Tableau de bord</h1>
    <div class="row g-4 mb-4">
        @foreach([['Utilisateurs actifs', $activeUsers, 'success', 'bx-user-check'], ['Utilisateurs bloqués', $blockedUsers, 'danger', 'bx-user-x'], ['Épargné ce mois', Number::currency($monthlyTotal, 'EUR', 'fr'), 'primary', 'bx-wallet']] as $stat)
            <div class="col-12 col-md-6 col-xl-4"><div class="card h-100"><div class="card-body d-flex align-items-center gap-3"><span class="avatar-initial rounded bg-label-{{ $stat[2] }} p-3"><i class="bx {{ $stat[3] }} fs-3"></i></span><div><small class="text-muted">{{ $stat[0] }}</small><div class="h3 mb-0 text-{{ $stat[2] }}">{{ $stat[1] }}</div></div></div></div></div>
        @endforeach
    </div>
    <div class="row g-4">
        @foreach([['10 utilisateurs récents', $users], ['10 gains récents', $gains], ['10 épargnes récentes', $savings]] as [$heading, $rows])
            <div class="col-12"><div class="card"><div class="card-header"><h5 class="mb-0">{{ $heading }}</h5></div><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>Référence</th><th>Libellé</th><th>Date</th></tr></thead><tbody>@forelse($rows as $row)<tr><td><small>{{ $row->uuid ?? $row->id }}</small></td><td>{{ $row->email ?? ($row->user?->email.' — '.Number::currency($row->amount, $row->currency, 'fr')) }}</td><td>{{ $row->created_at?->format('d/m/Y H:i') }}</td></tr>@empty<tr><td colspan="3" class="text-center text-muted py-4">Aucune donnée.</td></tr>@endforelse</tbody></table></div></div></div>
        @endforeach
    </div>
@endsection
