<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sentry\Laravel\Integration;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $payments = Payment::with(['sender', 'receiver'])->get();
        return response()->json(['data' => $payments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request): JsonResponse
    {
        try {
            
            $payment = Payment::create($request->validated());
            // Raise error for testing
            throw new \Exception('Payment test error');
            
            return response()->json(['data' => $payment], 201);
        } catch (\Exception $e) {
            // Log the error with Sentry
            \Sentry\captureException($e);
            
            return response()->json(['error' => 'Failed to create payment'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment): JsonResponse
    {
        // Debug: Check the loaded payment with relationships
        dump('Payment details:', $payment->toArray());
        dump('Sender details:', $payment->sender);
        dump('Receiver details:', $payment->receiver);
        
        return response()->json(['data' => $payment->load(['sender', 'receiver'])]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentRequest $request, Payment $payment): JsonResponse
    {
        try {
            $payment->update($request->validated());
            return response()->json(['data' => $payment]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update payment'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
