<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceAccessRequest;
use App\Models\ConnectionLog;

class DashboardController extends Controller
{
    public function index()
    {
        if (! session('is_logged_in')) {
            return redirect()->route('login')
                ->with('error', 'Please login first.');
        }

        $connectedDevices = Device::count();
        $adminCount = 1;
        $staffCount = 0;
        $guestCount = Device::where('role', 'guest')->count();

        $recentLogs = ConnectionLog::with('device')
            ->latest()
            ->limit(8)
            ->get();

        $pendingRequests = DeviceAccessRequest::where('status', 'pending')->count();

        return view('dashboard.index', compact(
            'connectedDevices',
            'adminCount',
            'staffCount',
            'guestCount',
            'recentLogs',
            'pendingRequests'
        ));
    }
}