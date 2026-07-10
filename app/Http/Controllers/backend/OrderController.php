<?php

namespace App\Http\Controllers\backend;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = "Orders List";
        $data['orders'] = Order::with('package')->latest()->paginate(20);
        return view('backend.admin.order.index', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['title'] = "Order Details";
        $data['order'] = Order::with('package')->findOrFail($id);
        return view('backend.admin.order.show', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('order.index')->with('success', 'Order deleted successfully.');
    }
}