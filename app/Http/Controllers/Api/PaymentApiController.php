<?php

namespace App\Http\Controllers\Api;

use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\HomePageContent;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentApiController extends ApiController
{
    /**
     * Initiate payment via SSLCommerz.
     */
    public function initiate(Request $request): JsonResponse
    {
        $settings = HomePageContent::first();
        if ($settings && isset($settings->ssl_status) && $settings->ssl_status == 0) {
            return $this->errorResponse('SSLCommerz payment gateway is currently disabled.', 400);
        }

        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

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

        try {
            $sslc = new SslCommerzNotification();
            $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

            if (!is_array($payment_options)) {
                $payment_options = json_decode($payment_options, true);
            }

            if (isset($payment_options['status']) && $payment_options['status'] == 'success') {
                return $this->successResponse([
                    'gateway_url' => $payment_options['data'],
                    'tran_id' => $tran_id,
                    'order_id' => $order->id,
                ], 'Payment initiated successfully');
            }

            $errorMsg = $payment_options['message'] ?? 'Payment initiation failed with gateway.';
            return $this->errorResponse($errorMsg, 400);
        } catch (\Exception $e) {
            return $this->errorResponse('Payment gateway error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get order details by transaction ID.
     */
    public function getOrder(string $tran_id): JsonResponse
    {
        $order = Order::with('package')->where('tran_id', $tran_id)->first();

        if (!$order) {
            return $this->errorResponse('Order not found', 404);
        }

        return $this->successResponse([
            'id' => $order->id,
            'tran_id' => $order->tran_id,
            'name' => $order->name,
            'email' => $order->email,
            'phone' => $order->phone,
            'amount' => (float) $order->amount,
            'currency' => $order->currency,
            'status' => $order->status,
            'created_at' => $order->created_at ? $order->created_at->format('M d, Y h:i A') : null,
            'package' => $order->package ? [
                'id' => $order->package->id,
                'package_name' => $order->package->package_name,
                'price' => (float) $order->package->price,
            ] : null,
        ]);
    }
}
