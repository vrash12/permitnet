@extends('layouts.app')

@section('content')
@php
    $pageTitle = 'Dashboard';

    function permitnetTimeAgo($date) {
        if (! $date) {
            return '';
        }

        return $date->diffForHumans([
            'parts' => 1,
            'short' => true,
        ]);
    }
@endphp

<div class="stat-grid">
    <div class="stat-card">
        <svg viewBox="0 0 24 24">
            <path d="M12 18.5l3.5-3.5a5 5 0 0 0-7 0L12 18.5zm-6.5-6.5l1.8 1.8a7 7 0 0 1 9.9 0L19 12a9.5 9.5 0 0 0-13.5 0zm-3.5-3.5l1.8 1.8a12 12 0 0 1 16.9 0l1.8-1.8a14.5 14.5 0 0 0-20.5 0zM12 22l2.2-2.2L12 17.6l-2.2 2.2L12 22z"/>
        </svg>

        <div>
            <div class="stat-number">{{ str_pad($connectedDevices ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="stat-label">Connected Devices</div>
        </div>
    </div>

    <div class="stat-card">
        <svg viewBox="0 0 24 24">
            <path d="M12 2c-2.5 0-4.5 2.2-4.5 5c0 2.7 2 5 4.5 5s4.5-2.3 4.5-5c0-2.8-2-5-4.5-5zm-7 20c.4-4.8 3.2-8 7-8s6.6 3.2 7 8H5zm7-7l-2 2l2 4l2-4l-2-2z"/>
        </svg>

        <div>
            <div class="stat-number">{{ str_pad($adminCount ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="stat-label">Admin</div>
        </div>
    </div>

    <div class="stat-card">
        <svg viewBox="0 0 24 24">
            <path d="M8 11c2.2 0 4-1.8 4-4S10.2 3 8 3S4 4.8 4 7s1.8 4 4 4zm8 0c2.2 0 4-1.8 4-4s-1.8-4-4-4c-.8 0-1.5.2-2.1.6A6 6 0 0 1 16 7a6 6 0 0 1-2.1 3.4c.6.4 1.3.6 2.1.6zM8 13c-3.3 0-6 1.7-6 4v3h12v-3c0-2.3-2.7-4-6-4zm8 0c-.7 0-1.3.1-1.9.2c1.2 1 1.9 2.3 1.9 3.8v3h6v-3c0-2.3-2.7-4-6-4z"/>
        </svg>

        <div>
            <div class="stat-number">{{ str_pad($staffCount ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="stat-label">Staff</div>
        </div>
    </div>

    <div class="stat-card">
        <svg viewBox="0 0 24 24">
            <path d="M12 12c2.8 0 5-2.2 5-5s-2.2-5-5-5s-5 2.2-5 5s2.2 5 5 5zm0 2c-4.4 0-8 2.2-8 5v3h16v-3c0-2.8-3.6-5-8-5z"/>
        </svg>

        <div>
            <div class="stat-number">{{ str_pad($guestCount ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="stat-label">Guest</div>
        </div>
    </div>
</div>

<div class="activity-panel">
    <div class="activity-title">
        Recent Activity
    </div>

    @forelse($recentLogs as $log)
        <div class="activity-row">
            <div class="device-icon">
                @php
                    $hostname = strtolower($log->device->hostname ?? '');
                    $isLaptop = str_contains($hostname, 'laptop') || str_contains($hostname, 'pc') || str_contains($hostname, 'desktop');
                @endphp

                @if($isLaptop)
                    <svg viewBox="0 0 24 24">
                        <path d="M4 5h16v10H4V5zm-2 12h20v2H2v-2z"/>
                    </svg>
                @else
                    <svg viewBox="0 0 24 24">
                        <path d="M7 1h10c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H7c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2zm0 3v15h10V4H7zm4 16v1h2v-1h-2z"/>
                    </svg>
                @endif
            </div>

            <div class="activity-info">
                <div class="activity-name">
                    {{ $log->device->hostname ?? $log->device->owner_name ?? 'Unknown Device' }}
                </div>

                <div class="activity-mac">
                    MAC Address: {{ $log->mac_address }}
                </div>
            </div>

            <div class="activity-time">
                {{ permitnetTimeAgo($log->created_at) }}
            </div>
        </div>
    @empty
        <div class="empty-state">
            No recent activity yet.
        </div>
    @endforelse
</div>
@endsection