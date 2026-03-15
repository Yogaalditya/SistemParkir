<?php

namespace App\Http\Controllers;

use App\Models\ParkingSession;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ParkingFlowController extends Controller
{
    public function scanByUser(Request $request): View
    {
        $user = $request->user();

        if (! $user || $user->isAdmin()) {
            return view('parking.invalid');
        }

        return view('parking.payment', [
            'user' => $user,
            'session' => $this->getOrCreateActiveSession($user),
        ]);
    }

    public function scan(string $token): View
    {
        $user = User::where('qr_token', $token)
            ->where('role', 'user')
            ->first();

        if (! $user) {
            return view('parking.invalid');
        }

        return view('parking.payment', [
            'user' => $user,
            'session' => $this->getOrCreateActiveSession($user),
        ]);
    }

    public function pay(Request $request, string $token): RedirectResponse
    {
        $request->validate([
            'payment_method' => ['required', Rule::in(['dana', 'ovo', 'gopay', 'shopeepay', 'cash'])],
        ]);

        $user = User::where('qr_token', $token)
            ->where('role', 'user')
            ->firstOrFail();

        $session = $user->parkingSessions()
            ->whereNull('checked_out_at')
            ->latest('checked_in_at')
            ->firstOrFail();

        $method = $request->string('payment_method')->toString();

        $session->payment_method = $method;

        if ($method === 'cash') {
            $session->payment_status = 'awaiting_admin_confirmation';
            $session->paid_at = null;
        } else {
            $session->payment_status = 'paid';
            $session->paid_at = now();
        }

        $session->save();

        return redirect()->route('parking.status', ['session' => $session->public_token]);
    }

    public function status(string $session): View
    {
        $parkingSession = ParkingSession::with('user')
            ->where('public_token', $session)
            ->firstOrFail();

        return view('parking.status', [
            'session' => $parkingSession,
            'currentFee' => $parkingSession->currentFee(),
            'durationMinutes' => $parkingSession->parkingDurationMinutes(),
        ]);
    }

    public function checkout(string $session): RedirectResponse
    {
        $parkingSession = ParkingSession::where('public_token', $session)->firstOrFail();

        if ($parkingSession->payment_status !== 'paid') {
            return back()->with('status', 'Pembayaran belum dikonfirmasi admin.');
        }

        if ($parkingSession->checked_out_at) {
            return back()->with('status', 'Sesi parkir sudah ditutup.');
        }

        $parkingSession->update([
            'checked_out_at' => now(),
        ]);

        return back()->with('status', 'Anda sudah keluar dari area parkir sekolah.');
    }

    private function getOrCreateActiveSession(User $user): ParkingSession
    {
        $session = $user->parkingSessions()
            ->whereNull('checked_out_at')
            ->latest('checked_in_at')
            ->first();

        if ($session) {
            return $session;
        }

        return ParkingSession::create([
            'user_id' => $user->id,
            'public_token' => (string) Str::uuid(),
            'checked_in_at' => now(),
            'base_fee' => 2000,
            'payment_status' => 'pending',
        ]);
    }
}
