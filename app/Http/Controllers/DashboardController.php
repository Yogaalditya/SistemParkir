<?php

namespace App\Http\Controllers;

use App\Models\ParkingSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function user(): View
    {
        $user = auth()->user();

        $activeSession = $user->parkingSessions()
            ->whereNull('checked_out_at')
            ->latest('checked_in_at')
            ->first();

        return view('user.dashboard', [
            'user' => $user,
            'activeSession' => $activeSession,
        ]);
    }

    public function admin(): View
    {
        $pendingCashSessions = ParkingSession::with('user')
            ->where('payment_status', 'awaiting_admin_confirmation')
            ->whereNull('checked_out_at')
            ->latest('checked_in_at')
            ->get();

        $activeSessions = ParkingSession::with('user')
            ->whereNull('checked_out_at')
            ->latest('checked_in_at')
            ->get();

        return view('admin.dashboard', [
            'pendingCashSessions' => $pendingCashSessions,
            'activeSessions' => $activeSessions,
        ]);
    }

    public function confirmCash(ParkingSession $session): RedirectResponse
    {
        if ($session->payment_status !== 'awaiting_admin_confirmation') {
            return back()->with('status', 'Pembayaran cash sudah diproses sebelumnya.');
        }

        $session->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'admin_confirmed_by' => auth()->id(),
        ]);

        return back()->with('status', 'Pembayaran cash berhasil dikonfirmasi.');
    }
}
