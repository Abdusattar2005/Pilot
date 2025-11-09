<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderRespond;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return JsonSend(Order::query()
            ->with('workingDays')
            ->with('licenses')
            ->orderBy('id', 'desc')
            ->paginate(50));
    }

    //откликнутся на заявку
    public function respond(int $id, Request $request)
    {
       $order = Order::find($id);
       if(empty($order)) CustomException(1025);
       $respond =  OrderRespond::firstOrCreate([
           'order_id' => $order->id,           
           'user_id' => $request->user()->id
       ]);
       return JsonSend($respond);
    }

}
