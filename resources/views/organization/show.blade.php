@extends('layouts.app')

@section('page-title', 'Organization')

@section('content')
<div class="member-panel">
    <div class="member-header">
        <div class="member-avatar">
            <svg viewBox="0 0 24 24">
                <path d="M12 2c-2.5 0-4.5 2.2-4.5 5c0 2.7 2 5 4.5 5s4.5-2.3 4.5-5c0-2.8-2-5-4.5-5zm-7 20c.4-4.8 3.2-8 7-8s6.6 3.2 7 8H5zm7-7l-2 2l2 4l2-4l-2-2z"/>
            </svg>
        </div>

        <div class="member-info">
            <h1>{{ $member->name }}</h1>

            <div class="member-row">
                <strong>Contact:</strong>
                <span>{{ $member->contact ?? 'N/A' }}</span>
            </div>

            <div class="member-row">
                <strong>Street:</strong>
                <span>{{ $member->street ?? 'N/A' }}</span>
            </div>

            <div class="member-row">
                <strong>City:</strong>
                <span>{{ $member->city ?? 'N/A' }}</span>
            </div>

            <div class="member-row">
                <strong>Position:</strong>
                <span>{{ $member->position }}</span>
            </div>
        </div>
    </div>

    <div class="devices-title">Devices :</div>

    <div class="member-device-list">
        @forelse($devices as $device)
            @php
                $hostname = strtolower($device->hostname ?? '');
                $isLaptop = str_contains($hostname, 'laptop') || str_contains($hostname, 'pc') || str_contains($hostname, 'desktop');
                $isOnline = $device->status === 'approved';
            @endphp

            <div class="member-device-card">
                <div class="member-device-icon">
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

                <div class="member-device-info">
                    <div class="member-device-name">
                        {{ $device->hostname ?? 'Unknown Device' }}
                    </div>

                    <div class="member-device-meta">
                        MAC Address: {{ $device->mac_address }}
                        &nbsp; • &nbsp;
                        IP Address: {{ $device->ip_address ?? 'N/A' }}
                    </div>

                    <div class="member-device-meta">
                        Role: {{ $device->role ?? $member->position }}
                    </div>
                </div>

                <div class="status-pill {{ $isOnline ? 'status-online' : 'status-offline' }}">
                    ● {{ $isOnline ? 'Online' : 'Offline' }}
                </div>
            </div>
        @empty
            <div class="empty-state">
                No devices assigned to this member yet.
            </div>
        @endforelse
    </div>
</div>
@endsection