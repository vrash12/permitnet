<?php

namespace App\Http\Controllers;

use App\Models\ConnectionLog;
use App\Models\Device;
use App\Models\DeviceAccessRequest;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        if (! session('is_logged_in')) {
            return redirect()->route('login')
                ->with('error', 'Please login first.');
        }

        $devices = Device::latest('updated_at')->get();

        return view('devices.index', compact('devices'));
    }

    public function approve(Device $device)
    {
        $device->update([
            'status' => 'approved',
        ]);

        DeviceAccessRequest::where('device_id', $device->id)
            ->where('status', 'pending')
            ->update([
                'status' => 'approved',
                'decided_by' => session('admin_id'),
                'decided_at' => now(),
            ]);

        ConnectionLog::create([
            'device_id' => $device->id,
            'mac_address' => $device->mac_address,
            'ip_address' => $device->ip_address,
            'hostname' => $device->hostname,
            'event_type' => 'access_decision',
            'action' => 'approved',
            'status' => 'success',
            'message' => 'Device approved by admin.',
        ]);

        $this->applyFirewall();

        return back()->with('success', 'Device approved. Firewall updated.');
    }

    public function deny(Device $device)
    {
        $device->update([
            'status' => 'denied',
        ]);

        DeviceAccessRequest::where('device_id', $device->id)
            ->where('status', 'pending')
            ->update([
                'status' => 'denied',
                'decided_by' => session('admin_id'),
                'decided_at' => now(),
            ]);

        ConnectionLog::create([
            'device_id' => $device->id,
            'mac_address' => $device->mac_address,
            'ip_address' => $device->ip_address,
            'hostname' => $device->hostname,
            'event_type' => 'access_decision',
            'action' => 'denied',
            'status' => 'success',
            'message' => 'Device denied by admin.',
        ]);

        $this->applyFirewall();

        return back()->with('success', 'Device denied. Firewall updated.');
    }

    public function updateRole(Request $request, Device $device)
    {
        $data = $request->validate([
            'role' => ['required', 'in:admin,staff,guest'],
            'owner_name' => ['nullable', 'string', 'max:255'],
        ]);

        $device->update($data);

        return back()->with('success', 'Device details updated.');
    }

    private function applyFirewall(): void
    {
        $script = base_path('apply_firewall.php');

        if (file_exists($script)) {
            shell_exec(PHP_BINARY . ' ' . escapeshellarg($script) . ' > /dev/null 2>&1 &');
        }
    }
}
