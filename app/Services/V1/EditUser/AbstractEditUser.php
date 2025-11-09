<?php

namespace App\Services\V1\EditUser;

use App\Models\User;
use App\Traits\TraitSsendingEmail;
use Illuminate\Support\Facades\DB;

use App\Actions\UserContract\UpdateUserContractAction;
use App\Actions\UserLicense\UpdateUserLicensesAction;
use App\Actions\UserPlane\UpdateUserPlanesAction;
use App\Actions\UserPosition\UpdateUserPositionAction;
use App\Actions\UserWorkingDays\UpdateUserWorkingDaysAction;
use App\Actions\Info\UpdateInfoUserAction;
use App\ValueObject\EditUser\AbstractEditUserVo;

abstract class AbstractEditUser
{
    use TraitSsendingEmail;
    protected $data;

    public function getResponse(): User
    {
        return $this->user;
    }

    public function __construct(
        protected User $user,
        protected AbstractEditUserVo $abstractEditUserVo
    ) {
        $this->data = $this->abstractEditUserVo->getValueValidated(); // lданные из реквеста валидированные       
        
        DB::transaction(function () {
            $this->editUser();
            $this->handle();
        });
    }

    abstract protected function handle(): void;

    protected function editUser(): void
    {
        $this->user->email = $this->data['email'];
        $this->user->phone = $this->data['phone'];
        $this->user->save();
    }

   
    protected function updateUserInfo(): void
    {
        $service = new UpdateInfoUserAction();
        $service->handle(
            $this->user->id,
            $this->data['name'],
            $this->data['age'] ?? 1,
            $this->data['total_flight_time'] ?? 0,
            $this->data['salary_min'] ?? 0,
            $this->data['salarie_type_id'] ?? 1,
            $this->data['country'] ?? null,
            $this->data['region']?? null,
            $this->data['city']?? null,
        );
    }

    protected function createUserWorkingDay(): void
    {
        $collect = collect($this->data["working_days"]);
        $dateList = $collect->pluck('date');
        
        $service = new UpdateUserWorkingDaysAction();
        $service->handle($this->user->id, $dateList);      
    }

    protected function createUserPlanes(): void
    {
        $collect = collect($this->data["planes"]);
        $planeIds = $collect->pluck('id');
        
        $service = new UpdateUserPlanesAction();
        $service->handle($this->user->id, $planeIds);
    }

    protected function createUserLicenses(): void
    {
        $collect = collect($this->data["license"]);
        $licenseIds = $collect->pluck('id');
        
        $service = new UpdateUserLicensesAction();
        $service->handle($this->user->id, $licenseIds);
    }

    protected function createUserContract(): void
    {
        $service = new UpdateUserContractAction();
        $service->handle($this->user->id, $this->data["contract"]);
    }

    protected function createUserPosition(): void
    {
        $service = new UpdateUserPositionAction();
        $service->handle($this->user->id, $this->data["position"]);
    }
}
