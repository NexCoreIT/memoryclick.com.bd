<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Package;
use App\Models\HomePageContent;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Inertia\Inertia;

class SslCommerzPaymentController extends Controller
{
    public function index(Request $request)
    {
        $package = Package::findOrFail($request->package_id);
        $settings = HomePageContent::find(1);
        return view('frontend.package.checkout', compact('package', 'settings'));
    }

    public function payViaAjax(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postcode' => 'nullable|string|max:20',
            'country' => 'required|string|max:50',
        ]);

        $package = Package::findOrFail($request->package_id);

        # Generate unique transaction ID
        $tran_id = uniqid('MC_');

        # Create the order in database
        $order = Order::create([
            'package_id' => $package->id,
            'tran_id' => $tran_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postcode' => $request->postcode,
            'country' => $request->country,
            'amount' => $package->price,
            'currency' => 'BDT',
            'status' => 'pending',
        ]);

        $post_data = [];
        $post_data['total_amount'] = $package->price;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $tran_id;
        $post_data['product_category'] = "photography-package";

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->name;
        $post_data['cus_email'] = $request->email;
        $post_data['cus_add1'] = $request->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = $request->city;
        $post_data['cus_state'] = $request->state ?? "";
        $post_data['cus_postcode'] = $request->postcode ?? "0000";
        $post_data['cus_country'] = $request->country;
        $post_data['cus_phone'] = $request->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['shipping_method'] = "NO";
        $post_data['num_of_item'] = 1;
        $post_data['ship_name'] = $request->name;
        $post_data['ship_add1'] = $request->address;
        $post_data['ship_city'] = $request->city;
        $post_data['ship_state'] = $request->state ?? "";
        $post_data['ship_postcode'] = $request->postcode ?? "0000";
        $post_data['ship_country'] = $request->country;

        # PRODUCT INFORMATION
        $post_data['product_name'] = $package->package_name;
        $post_data['product_category'] = "photography-package";
        $post_data['product_profile'] = "non-physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $package->id;
        $post_data['value_b'] = $order->id;
        $post_data['value_c'] = $tran_id;

        $sslc = new SslCommerzNotification();
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            $payment_options = json_decode($payment_options, true);
        }

        if (isset($payment_options['status']) && $payment_options['status'] == 'success') {
            $gatewayUrl = $payment_options['data'];

            // AJAX request - return JSON for embed popup
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $gatewayUrl,
                    'logo' => $payment_options['logo'] ?? '',
                ]);
            }

            // Regular form POST - redirect directly to SSLCommerz gateway
            return redirect()->away($gatewayUrl);
        } else {
            $errorMsg = $payment_options['message'] ?? 'Payment initiation failed. Please try again.';

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => $errorMsg,
                ]);
            }

            return redirect()->back()->with('error', $errorMsg)->withInput();
        }
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        # Check order status in database
        $order = Order::where('tran_id', $tran_id)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found!');
        }

        # Validate the transaction
        $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

        if ($validation == TRUE) {
            # Update order status
            $order->update([
                'status' => 'completed',
                'val_id' => $request->input('val_id'),
                'bank_tran_id' => $request->input('bank_tran_id'),
                'card_type' => $request->input('card_type'),
                'card_no' => $request->input('card_no'),
                'card_issuer' => $request->input('card_issuer'),
                'card_brand' => $request->input('card_brand'),
                'card_issuer_country' => $request->input('card_issuer_country'),
                'currency_amount' => $request->input('currency_amount'),
                'currency_rate' => $request->input('currency_rate'),
                'base_fair' => $request->input('base_fair'),
                'response_data' => json_encode($request->all()),
            ]);

            $frontendUrl = env('FRONTEND_URL');
            if (!empty($frontendUrl)) {
                return redirect(rtrim($frontendUrl, '/') . '/payment/success/' . $tran_id);
            }

            return redirect()->route('payment.success.page', ['tran_id' => $tran_id])
                ->with('success', 'Payment completed successfully!');
        } else {
            $order->update([
                'status' => 'failed',
                'response_data' => json_encode($request->all()),
            ]);

            $frontendUrl = env('FRONTEND_URL');
            if (!empty($frontendUrl)) {
                return redirect(rtrim($frontendUrl, '/') . '/payment/fail/' . $tran_id);
            }

            return redirect()->route('payment.fail.page', ['tran_id' => $tran_id])
                ->with('error', 'Payment validation failed!');
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order = Order::where('tran_id', $tran_id)->first();
        if ($order) {
            $order->update([
                'status' => 'failed',
                'response_data' => json_encode($request->all()),
            ]);
        }

        $frontendUrl = env('FRONTEND_URL');
        if (!empty($frontendUrl)) {
            return redirect(rtrim($frontendUrl, '/') . '/payment/fail/' . $tran_id);
        }

        return redirect()->route('payment.fail.page', ['tran_id' => $tran_id])
            ->with('error', 'Payment failed! Please try again.');
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order = Order::where('tran_id', $tran_id)->first();
        if ($order) {
            $order->update([
                'status' => 'canceled',
                'response_data' => json_encode($request->all()),
            ]);
        }

        $frontendUrl = env('FRONTEND_URL');
        if (!empty($frontendUrl)) {
            return redirect(rtrim($frontendUrl, '/') . '/payment/cancel/' . $tran_id);
        }

        return redirect()->route('payment.cancel.page', ['tran_id' => $tran_id])
            ->with('error', 'Payment was canceled.');
    }

    public function ipn(Request $request)
    {
        # Received the POST request from SSLCommerz endpoint
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();
        $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

        if ($validation == TRUE) {
            $order = Order::where('tran_id', $tran_id)->first();
            if ($order) {
                $order->update([
                    'status' => 'completed',
                    'val_id' => $request->input('val_id'),
                    'bank_tran_id' => $request->input('bank_tran_id'),
                    'card_type' => $request->input('card_type'),
                    'card_no' => $request->input('card_no'),
                    'card_issuer' => $request->input('card_issuer'),
                    'card_brand' => $request->input('card_brand'),
                    'card_issuer_country' => $request->input('card_issuer_country'),
                    'currency_amount' => $request->input('currency_amount'),
                    'currency_rate' => $request->input('currency_rate'),
                    'base_fair' => $request->input('base_fair'),
                    'response_data' => json_encode($request->all()),
                ]);
            }
        }

        return response('IPN processed', 200);
    }

    public function paymentSuccessPage($tran_id)
    {
        $order = Order::with('package')->where('tran_id', $tran_id)->firstOrFail();
        return Inertia::render('Payment/Success', [
            'tran_id' => $tran_id,
            'order' => [
                'id' => $order->id,
                'tran_id' => $order->tran_id,
                'name' => $order->name,
                'email' => $order->email,
                'amount' => $order->amount,
                'currency' => $order->currency,
                'status' => $order->status,
                'package' => $order->package ? [
                    'id' => $order->package->id,
                    'package_name' => $order->package->package_name,
                ] : null,
            ],
        ]);
    }

    public function paymentFailPage($tran_id)
    {
        $order = Order::where('tran_id', $tran_id)->first();
        return Inertia::render('Payment/Fail', [
            'tran_id' => $tran_id,
            'order' => $order,
        ]);
    }

    public function paymentCancelPage($tran_id)
    {
        $order = Order::where('tran_id', $tran_id)->first();
        return Inertia::render('Payment/Cancel', [
            'tran_id' => $tran_id,
            'order' => $order,
        ]);
    }
}