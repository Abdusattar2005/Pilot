<?php

namespace App\Http\Controllers\Api\V1\Company;

use App\Http\Controllers\Controller;
use App\Models\InfoCompany;
use App\Models\Order;
use App\Models\OrderRespond;
use App\Services\V1\Order\Create\OrderFactory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function editStatusApproved(int $id, Request $request)
    {
        $request->validate([
            'status_approved' => 'required|in:1,2',
        ]);
        
        //имея отклик нужно найти ид компании по цепочки
        $respond = OrderRespond::find($id);
        if(empty($respond)) CustomException(1026);
        $order = Order::select('id', 'company_id')->find($respond->order_id);
        if(empty($order)) CustomException(1025);
        $company = InfoCompany::select('id', 'user_id')->find($order->company_id);
        if(empty($company)) CustomException(1024);
        //относится ли наша компания вообще к нашему отклику на заявку
        if((int) auth()->user()->id !== (int) $company->user_id) CustomException(1026);
        $respond->status_approved = $request->status_approved;
        $respond->save();
        return JsonSend($respond);
    }
    
    
    public function store(Request $request)
    {
        $position_id = $request->position_id ?? 0;
        $service = OrderFactory::handle($position_id, $request->all());
        return JsonSend($service->getResponse());
    }

    public function index(Request $request)
    {
        $company = InfoCompany::where('user_id', auth()->user()->id)->first();
        return JsonSend(Order::query()
            ->with('workingDays')
            ->with('licenses')
            ->where('company_id', $company->id ?? 0)
            ->orderBy('id', 'desc')
            ->paginate(50));
    }

    public function show(int $id, Request $request)
    {
        $company = InfoCompany::where('user_id', auth()->user()->id)->first();
        return JsonSend(
            Order::query()
                ->with('workingDays')
                ->with('licenses')
                ->with([
                    'responses' => fn ($query) =>
                    $query->with([
                        'user' => fn ($query) =>
                        $query->select(['id', 'phone', 'email'])
                            ->with('infoUser')
                            ->with('licenses')
                            ->with('planes')
                            ->with('position')
                            ->with('contract')
                    ])

                ])
                ->where([
                    'id' => $id,
                    'company_id' => $company->id ?? 0
                ])
                ->first()
        );
    }

    public function delete(int $id, Request $request)
    {
        $company = InfoCompany::where('user_id', auth()->user()->id)->first();        
        Order::where([
            'id' => $id,
            'company_id' => $company->id ?? 0
        ])->delete();
        return JsonSend(code: 410);
    }
}
