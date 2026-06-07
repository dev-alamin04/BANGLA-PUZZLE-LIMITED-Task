<?php

namespace App\Http\Controllers\Web\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\AnalyticsEventsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripePaymentController extends Controller
{
    protected AnalyticsEventsService $analytics;

    public function __construct(AnalyticsEventsService $analytics)
    {
        $this->analytics = $analytics;
    }

    /**
     * Handle successful payment
     */
    public function success(Request $request)
    {
        try {
            $sessionId = $request->get('session_id');
            $orderId = $request->get('order_id');


            // Get order details
            $order = null;
            if ($orderId) {
                $order = Order::find($orderId);

                // Update order status if needed
                if ($order && $sessionId) {
                    // Save analytic event
                    $this->analytics->log($order->user, 'order_placed', [
                        'order_id' => $order->id,
                        'amount'   => $order->total,
                    ]);
                }
            }
            return view('payments.success', [
                'order' => $order,
                'session_id' => $sessionId
            ]);
        } catch (\Exception $e) {
            Log::error('Payment success page error', [
                'error' => $e->getMessage(),
                'order_id' => $request->get('order_id')
            ]);

            return view('payments.success', [
                'order' => null,
                'session_id' => null,
                'error' => 'Unable to retrieve payment details'
            ]);
        }
    }

    /**
     * Handle cancelled payment
     */
    public function cancel(Request $request)
    {
        try {
            $orderId = $request->get('order_id');
            // Log cancelled payment
            Log::info('Payment cancelled', [
                'order_id' => $orderId,
                'user_id' => auth()->id()
            ]);

            // Get order details
            $order = null;
            if ($orderId) {
                $order = Order::find($orderId);

                // Update order status if needed
                if ($order) {
                    $order->update([
                        'status' => 'cancelled',
                        'payment_status' => 'cancelled'
                    ]);
                }
            }

            return view('payments.cancel', [
                'order' => $order
            ]);
        } catch (\Exception $e) {
            Log::error('Payment cancel page error', [
                'error' => $e->getMessage(),
                'order_id' => $request->get('order_id')
            ]);

            return view('payments.cancel', [
                'order' => null,
                'error' => 'Unable to retrieve order details'
            ]);
        }
    }
}
