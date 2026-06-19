@extends('layouts.app')

@section('content')
<style>
    .devices-panel {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 3px 7px rgba(0,0,0,0.16);
    }

    .devices-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 18px;
    }

    .devices-title {
        font-size: 26px;
        font-weight: 800;
    }

    .devices-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-top: 5px;
    }

    .success-alert {
        background: #dcfce7;
        color: #15803d;
        padding: 12px 14px;
        border-radius: 8px;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .device-table {
        width: 100%;
        border-collapse: collapse;
    }

    .device-table th,
    .device-table td {
        border-bottom: 1px solid #e5e7eb;
        padding: 12px 10px;
        text-align: left;
        font-size: 14px;
        vertical-align: middle;
    }

    .device-table th {
        font-weight: 800;
        color: #334155;
        background: #f8fafc;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 92px;
        height: 30px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
    }

    .status-approved {
        background: #dcfce7;
        color: #15803d;
    }

    .status-pending {
        background: #fef9c3;
        color: #a16207;
    }

    .status-denied {
        background: #fee2e2;
        color: #b91c1c;
    }

    .device-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn {
        border: 0;
        border-radius: 7px;
        padding: 8px 11px;
        font-family: 'Work Sans', Arial, sans-serif;
        font-weight: 800;
        cursor: pointer;
        font-size: 12px;
    }

    .btn-approve {
        background: #16a34a;
        color: white;
    }

    .btn-deny {
        background: #ef4444;
        color: white;
    }

    .btn-save {
        background: #1293ee;
        color: white;
    }

    .device-form {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        align-items: center;
    }

    .device-form input,
    .device-form select {
        height: 34px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        padding: 0 8px;
        font-size: 12px;
    }

    .empty-state {
        padding: 22px;
        color: #64748b;
    }

    @media (max-width: 950px) {
        .devices-panel {
            overflow-x: auto;
        }

        .device-table {
            min-width: 920px;
        }
    }
</style>

<div class="devices-panel">
    <div class="devices-header">
        <div>
            <div class="devices-title">Devices</div>
            <div class="devices-subtitle">
                Devices connected to PermitNet Wi-Fi appear here after running scan_devices.php.
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="success-alert">
            {{ session('success') }}
        </div>
    @endif

    <table class="device-table">
        <thead>
            <tr>
                <th>Device</th>
                <th>IP Address</th>
                <th>MAC Address</th>
                <th>Status</th>
                <th>Role / Owner</th>
                <th>Last Seen</th>
                <th>Access</th>
            </tr>
        </thead>

        <tbody>
            @forelse($devices as $device)
                <tr>
                    <td>
                        <strong>{{ $device->hostname ?? 'Unknown Device' }}</strong>
                    </td>

                    <td>{{ $device->ip_address ?? 'N/A' }}</td>

                    <td>{{ $device->mac_address }}</td>

                    <td>
                        <span class="status-pill status-{{ $device->status }}">
                            {{ strtoupper($device->status) }}
                        </span>
                    </td>

                    <td>
                        <form method="POST" action="{{ route('devices.role', $device) }}" class="device-form">
                            @csrf
                            @method('PUT')

                            <select name="role">
                                <option value="guest" {{ $device->role === 'guest' ? 'selected' : '' }}>Guest</option>
                                <option value="staff" {{ $device->role === 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="admin" {{ $device->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>

                            <input type="text" name="owner_name" value="{{ $device->owner_name }}" placeholder="Owner">

                            <button class="btn btn-save" type="submit">Save</button>
                        </form>
                    </td>

                    <td>
                        {{ $device->last_seen_at ? $device->last_seen_at->diffForHumans() : 'N/A' }}
                    </td>

                    <td>
                        <div class="device-actions">
                            <form method="POST" action="{{ route('devices.approve', $device) }}">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-approve" type="submit">Approve</button>
                            </form>

                            <form method="POST" action="{{ route('devices.deny', $device) }}">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-deny" type="submit">Deny</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        No devices detected yet. Connect a device to PermitNet Wi-Fi, then run: sudo php scan_devices.php
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
