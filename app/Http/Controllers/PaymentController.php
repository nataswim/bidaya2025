<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function index()
    {
        // Initialiser Stripe ici
        Stripe::setApiKey(config('stripe.secret_key'));
        
        $user = auth()->user();
        $plans = config('stripe.plans');
        $hasCompletedPayment = $user->payments()->where('status', 'completed')->exists();

        return view('payments.index', compact('plans', 'hasCompletedPayment'));
    }

    public function createPaymentIntent(Request $request)
{
    Stripe::setApiKey(config('stripe.secret_key'));
    
    $request->validate([
        'plan' => 'required|in:3_months,6_months,12_months'
    ]);

    $user = auth()->user();
    $plan = config("stripe.plans.{$request->plan}");

    // Annuler les paiements pending existants pour cet utilisateur
    Payment::where('user_id', $user->id)
        ->where('status', 'pending')
        ->update(['status' => 'cancelled']);

    try {
        $paymentIntent = PaymentIntent::create([
            'amount' => $plan['price'],
            'currency' => 'eur',
            'metadata' => [
                'user_id' => $user->id,
                'plan_type' => $request->plan,
            ]
        ]);

        Payment::create([
            'user_id' => $user->id,
            'plan_type' => $request->plan,
            'amount_paid' => $plan['price'],
            'stripe_payment_intent_id' => $paymentIntent->id,
            'status' => 'pending'
        ]);

        return response()->json([
            'client_secret' => $paymentIntent->client_secret
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Erreur: ' . $e->getMessage()
        ], 500);
    }
}
    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_intent' => 'required|string'
        ]);

        $payment = Payment::where('stripe_payment_intent_id', $request->payment_intent)->first();

        if ($payment) {
            $payment->update(['status' => 'completed']);
            
            return redirect()->route('dashboard')
                ->with('success', 'Paiement reussi ! Un administrateur validera votre acces premium prochainement.');
        }

        return redirect()->route('payments.index')
            ->with('error', 'Paiement non trouve.');
    }

    public function history()
    {
        $user = auth()->user();
        $payments = $user->payments()
            ->with('processedBy')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('payments.history', compact('payments'));
    }
}