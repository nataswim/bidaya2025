<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Role;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private function checkAdminAccess()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Accès non autorisé');
        }
    }

    public function index(Request $request)
    {
        $this->checkAdminAccess();
        
        $status = $request->get('status', 'pending');
        
        $payments = Payment::with(['user', 'processedBy'])
            ->when($status === 'pending', function($query) {
                $query->where('admin_status', 'pending')->where('status', 'completed');
            })
            ->when($status === 'all', function($query) {
                // Tous les paiements
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.payments.index', compact('payments', 'status'));
    }

    public function approve(Payment $payment)
    {
        $this->checkAdminAccess();
        
        $userRole = Role::where('name', 'user')->first();
        
        if ($userRole) {
            $payment->user->update(['role_id' => $userRole->id]);
            
            $payment->update([
                'admin_status' => 'approved',
                'processed_by' => auth()->id(),
                'processed_at' => now(),
                'admin_notes' => 'Rôle changé vers utilisateur premium'
            ]);
            
            return redirect()->back()
                ->with('success', "Paiement approuvé. {$payment->user->name} est maintenant utilisateur premium.");
        }
        
        return redirect()->back()->with('error', 'Erreur lors du changement de rôle.');
    }

    public function reject(Request $request, Payment $payment)
    {
        $this->checkAdminAccess();
        
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);
        
        $payment->update([
            'admin_status' => 'rejected',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'admin_notes' => $request->reason
        ]);
        
        return redirect()->back()
            ->with('success', 'Paiement rejeté avec motif.');
    }
}