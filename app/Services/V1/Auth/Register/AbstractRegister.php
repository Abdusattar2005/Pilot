<?php

namespace App\Services\V1\Auth\Register;

use App\Models\Role;
use App\Models\User;
use App\Services\V1\Auth\AuthService;
use App\ValueObject\Register\AbstractRegisterVo;
use App\Traits\TraitSsendingEmail;
use Illuminate\Support\Facades\DB;

use App\Actions\UserContract\UpdateUserContractAction;
use App\Actions\UserLicense\UpdateUserLicensesAction;
use App\Actions\UserPlane\UpdateUserPlanesAction;
use App\Actions\UserPosition\UpdateUserPositionAction;
use App\Actions\UserWorkingDays\UpdateUserWorkingDaysAction;
use App\Actions\Info\UpdateInfoUserAction;

abstract class AbstractRegister
{
    use TraitSsendingEmail;
    protected $data;
    protected int $code;
    protected User $user;

    public function getResponse(): User
    {
        return $this->authService->getToken($this->user);
    }

    public function __construct(
        protected int $roleId,
        protected AbstractRegisterVo $abstractRegisterVo,
        protected AuthService $authService = new AuthService
    ) {
        $this->data = $this->abstractRegisterVo->getValueValidated(); // lданные из реквеста валидированные
        $this->randCode();
        DB::transaction(function () {
            $this->registerUser();
            $this->createInfo(); //создание различной инфоромации
        });
        $this->sendEmail();
    }

    protected function randCode(): void
    {
        $this->code = rand(10000, 99999);
    }

    protected function createUser(int $roleId, string $email, int $phone, string $password, int $verification_code): void
    {
        $user = User::create([
            'role_id' => $roleId,
            'email' => $email,
            'phone' => $phone,
            'password' => bcrypt($password),
            //'verification_code' => $verification_code,// пока не надо
            'email_verified_at' => now(), // автоматом верифицирован
        ]);
        $user->assignRole(Role::getRoleName($roleId));
        $this->user = $user;
    }

    //в данный момент верификация почты не нужна
    protected function sendEmail(): void
    {
        //if(empty($this->data['email'])) return;
        //$this->SendVerificationEmail($this->data['email'], $this->code);
    }

    abstract protected function registerUser(): void;
    abstract protected function createInfo(): void;

    protected function createUserInfo(): void
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
