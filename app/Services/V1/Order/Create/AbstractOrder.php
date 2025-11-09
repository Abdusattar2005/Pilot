<?php

namespace App\Services\V1\Order\Create;

use App\Actions\OrderLicenses\CreateLicensesAction;
use App\Actions\OrderWorkingDays\CreaterWorkingDaysAction;
use App\Models\InfoCompany;
use App\Models\Order;
use App\Models\Role;
use App\ValueObject\Order\Create\AbstractCreateOrderVo;
use Illuminate\Support\Facades\DB;

abstract class AbstractOrder
{
    public function getResponse(): Order
    {
        return $this->order;
    }

    private InfoCompany $company;
    protected Order $order;

    protected object $data;

    public function __construct(        
        protected AbstractCreateOrderVo $abstractCreateOrderVo,        
    ) {
        $this->data = $this->abstractCreateOrderVo->getValueValidatedObject(); // данные из реквеста валидированные       
        $this->getCompany();

        DB::transaction(function () {
            $this->createOrder();
            $this->handle();
        });        
        //d($this::class);
    }

    abstract protected function handle(): void;

    private function getCompany(): void
    {
        $company = InfoCompany::where(['user_id'=>auth()->user()->id])->first();
        if(empty($company)) CustomException(1024);
        $this->company = $company;
        $this->data->company_id = $this->company->id;
    }
    private function createOrder(): void
    {
        //d($this->data);
        $this->order = Order::create([
            'company_id' => $this->data->company_id,
            'position_id' => $this->data->position_id,
            'contract_id' => $this->data->contract_id,
            'plane_id'=>$this->data->plane_id,
            'comment'=>$this->data->comment,
            'total_flight_time'=>$this->data->total_flight_time ?? 0,
            'salary_min'=>$this->data->salary_min ?? 0,
            'salarie_type_id'=>$this->data->salarie_type_id ?? 1,
            'departure'=>$this->data->departure,
            'departure_date'=>$this->data->departure_date,
            'arrival'=>$this->data->arrival,
            'arrival_date'=>$this->data->arrival_date,
        ]);
    }

    protected function createWorkingDay(): void
    {
        $collect = collect($this->data->working_days);
        $dateList = $collect->pluck('date');
        
        $service = new CreaterWorkingDaysAction();
        $service->handle($this->order->id, $dateList);      
    }

    protected function createLicenses(): void
    {
        $collect = collect($this->data->license);
        $licenseIds = $collect->pluck('id');
       
        $service = new CreateLicensesAction();
        $service->handle($this->order->id, $licenseIds);    
    }
}
