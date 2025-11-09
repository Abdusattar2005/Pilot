<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
//use Propaganistas\LaravelPhone\PhoneNumber;
use App\Services\V1\Auth\Register\RegisterFactory;
use App\Traits\TraitSsendingEmail;
use Illuminate\Support\Facades\Hash;
use App\Services\V1\Auth\AuthService;


class AuthController extends Controller
{
    use TraitSsendingEmail;

    public function register(Request $request)
    {
        $role_id = $request->role_id ?? 0;
        $user = RegisterFactory::createUser($role_id, $request->all());       
        return JsonSend($user->getResponse());
    }
    
    public function login(Request $request, AuthService $authService)
    {
        $request->validate([
            "email"=> "required|email",                 
            'password' => 'required|string|min:8|max:50',
        ]);

        $user = User::where('email', $request->email)->first();
        if(empty($user)) CustomException(1016);
        if(!Hash::check($request->password, $user->password)) CustomException(1017);      
        $user = $authService->getToken($user);
        return JsonSend($user);
    }
    
    public function info(Request $request)
    {
        $userRoleId = auth()->user()->role_id;
        $user = User::query()

        ->when(in_array($userRoleId, [1]), function ($query) {
            $query->with('infoCompany');                     
        })

        ->when(in_array($userRoleId, [2,3,4]), function ($query) {
            $query->with('workingDays');
            $query->with('infoUser');
            $query->with('planes'); 
            $query->with('position');      
            $query->with('contract');         
        })

        ->when(in_array($userRoleId, [2]), function ($query) {
            $query->with('licenses');                     
        })
        
        ->with('roles')
        ->find(auth()->user()->id);
        return JsonSend($user);
    }

    public function logout(Request $request) {
        //$request->user()->currentAccessToken()->delete();//удалить действующий токен
        $request->user()->tokens()->delete();//удалить все токены
        //auth()->user()->tokens()->delete();        
        return JsonSend('User successfully signed out');
    }

    public function password_edit(Request $request) {
        $request->validate([
            'old_password' => 'required|string|min:8|max:50',
            'new_password' => 'required|string|min:8|max:50',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = User::find(auth()->user()->id);   
        if(!Hash::check($request->old_password, $user->password)) CustomException(1019);
        $user->password = bcrypt($request->new_password);
        $user->save();
        return JsonSend();
    }

    public function password_reset(Request $request) {
        $request->validate([
            "email"=> "required|email",
            "code"=> 'required|integer',
            'password' => 'required|string|min:8|max:50',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::where('email', $request->email)->first();
        if(empty($user))    CustomException(1016);        
        if((int) $user->code !== (int)$request->code){
            $user->code = null;
            $user->save();
            CustomException(1020); 
        }
        $user->password = bcrypt($request->password);
        $user->code = null;
        $user->save();
        return JsonSend();
    }

    public function resend_email_code(Request $request){
        $request->validate([
            "email"=> "required|email",
        ]);
        $user = User::where('email', $request->email)->first();
        if(empty($user)) CustomException(1016); 

        $code = rand(100000, 999999);
        $this->SendCodeInEmail($user->email, $code);
        $user->code = $code;
        $user->save();
        return JsonSend();
    }

    /*private object $user;

    public function password_reset(ResetPasswordRequest $request){

        $user = User::where('email', $request->email)->first();
        if(!$user) CustomException::error(4);
        if(!$user->password) CustomException::error(10);
        if(!$user->code) CustomException::error(13);
        if((string) $user->code !== (string)$request->code) CustomException::error(14);
        $user->password = bcrypt($request->password);
        $user->code = null;
        $user->save();
        return Json::send(15);
    }

    public function password_email(ResendEmailCodeRequest $request){
        $user = User::where('email', $request->email)->first();
        if(!$user) CustomException::error(4);
        if(!$user->password) CustomException::error(10);
        $code = $this->SendEmailResetPassword($request->email);
        $user->code = $code;
        $user->save();
        return Json::send(9);
    }

    public function resend_email_code(ResendEmailCodeRequest $request){
        $user = User::where('email', $request->email)->first();
        if(!$user) CustomException::error(4);
        if($user->email_verified_at) CustomException::error(5);
        $code = $this->SendVerificationEmail($request->email);
        $user->verification_code = $code;
        $user->save();
        return Json::send(9);
    }

    public function verification_email(VerificationEmailRequest $request){
        $user = User::where('email', $request->email)->first();
        if(!$user) CustomException::error(4);
        if($user->email_verified_at) CustomException::error(5);
        if(!$user->verification_code) CustomException::error(6);
        if((string) $user->verification_code !== (string) $request->code) CustomException::error(7);
        $user->email_verified_at = now();
        //$user->verification_code = null;        
        $user->save();
        //return Json::send(5);
        //внизу сделал авторизацию сразу
        Auth::guard('api')->login($user);
        $this->user = $user;
        $token = $this->createToken();
        return Json::send($token);   
        
        ///        $phone =  ConvertPhone($phone);      
        $owner = Owner::where(['phone' => $phone])->first();
        if(!$owner) NotificationException(3, 404);
        $checkPassword = Hash::check($password, $owner->password);
        if(!$checkPassword) CustomException(1, 403);
        
        Auth::login($owner);
        
        return $this->authService->CreateToken($owner, ['owner']);   
    }

    //скрытая авторизация для мастера моб прилождении
    public function hidden_authorization(HiddenAuthorizationRequest $request, $role)
    {

        $this->checkRole($role);
        if($request->token != 'tVlC0oaDneovZAx0N8hzGgzIIByqhlQroSYuGhYj') CustomException::error(1000);
        $userCreated = User::firstOrCreate(//ищет запись, по 1 массииву, если нету создает новое с данными из 2х масивов
            [
                'email' => $request->email
            ],
            [
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt(Str::random(12))
            ]
        );

        //если не будет ни одной роли то создаст / иначе если роль есть то не создаем новую роль
        if(!$userCreated->hasRole(Role::all()->pluck('name')->toArray())) {
            $userCreated->assignRole($role);
            DefaultService::run($userCreated->id, $role);//дефолтные данные
        }

        $this->user = $userCreated;

        $token = $this->createToken();
        return Json::send($token);
    }


    public function login(AuthLoginRequest $request){ 

        if(Auth::guard('api')->attempt(['email' => $request->email, 'password' => $request->password])){
            if(!Auth::user()->email_verified_at) CustomException::error(8);
            $this->user = Auth::user();
            $token = $this->createToken();
            return Json::send($token);
        }
        CustomException::error(1);
    }

    public function login_executor(AuthExecutorLoginRequest $request){
            $user = \App\Models\SalonExecutor::select('id','name','activity','login','password_hash')
            ->where('login', $request->login)->first();
            if(!$user) CustomException::error(32);
            $pass = Hash::check($request->password, $user->password_hash);
            if(!$pass)CustomException::error(1);

            //Auth::guard('executor')->login($user);//Авторизация по экземпляру
            //Auth::guard('executor')->loginUsingId($user->id);//автор по ид юзера но будет неверная роль --
            //echo Auth::guard('executor')->id();//дать его ID //
            //auth()->user()->id поч не работает если указать guard
            Auth::login($user);//надо авторизовывать по экземплару так как там написано модель и он по ней чекает правильную роль
            //если по ID авторизовывать то будет ошибочная роль
            $this->user = $user;
            $token = $this->createToken();
            return Json::send($token);
    }

    public function register($role, AuthRegisterRequest $request, \App\Services\V1\Referral\CreateUserReferralService $service)
    {
        $this->checkRole($role);
        //PhoneNumber::make($request->phone, 'RU')->formatForMobileDialingInCountry('RU');
        $input = $request->validated();
        $code = $this->SendVerificationEmail($request->email);

        $input['password'] = bcrypt($input['password']);
        $input['verification_code'] = $code;
        $user = User::create($input);
        if(!empty($user->id) && !empty($request->referral_id)){
            $service->handle($user->id, $request->referral_id);
        }
        $user->assignRole($role);
        DefaultService::run($user->id, $role);//дефолтные логотипы
            //$this->user = $user;
            //$token = $this->createToken();
        return Json::send(3);
    }

    public function logout(Request $request) {
        //$request->user()->currentAccessToken()->delete();//удалить действующий токен
        $request->user()->tokens()->delete();//удалить все токены
        //auth()->user()->tokens()->delete();
        return Json::send(['message' => 'User successfully signed out']);
    }

    public function user_info(Request $request) {
        $user_info = $request->user()->toArray();
        $user_info['role'] = $this->getMyRole();
        $user_info['appearance'] = \App\Models\Appearance::where('user_id', auth()->user()->id)->first();//ЛОГО
        $user_info['link'] = \App\Models\LinkProfile::select('link')->where('user_id', auth()->user()->id)->first();
        if($user_info['role'] == 'salon'){
            $user_info['dop_info'] = \App\Models\SalonInfo::select('name')->where('salon_id', auth()->user()->id)->first();
        }
        if($user_info['role'] == 'master'){
            $user_info['dop_info'] = \App\Models\MasterInfo::select('fio as name')->where('master_id', auth()->user()->id)->first();
        }
        unset($user_info['roles']);
        return Json::send($user_info);
    }

    public function redirectToProvider($provider, $role)
    {
        $this->checkRole($role);
        $config = $this->SocialiteOverridingConfig($provider, $role);//новый конфиг
        return Socialite::driver($provider)->setConfig($config)->stateless()->redirect();//stateless убираем сесии работа с API
    }

        //сюда возвращает соц сети
    public function handleProviderCallback($provider, $role)
    {
        //Callback передает сallback?code=6e8fdfbed057a6b5dc его я так понял можно принять 1 раз, чтобы его запустить например в постмане
        //мы имено здесь пишем exit; в брайзере http://localhost/api/v1/auth/vkontakte/login
        //нас переадресует с Callback скрипт остановится здесь, мы копируем всю ссылку с Callback и запихиваем в постман и там запускаем
        //это для того чтобы узера переадресовать на фронтенд а верстальщик мог этот ?code=6e8fdfbed057a6b5dc передать нам в Бэк и получить токен
        //exit;
        $this->checkRole($role);
        try {
            //принимаем Callback 1 раз, в нем code (одноразовый)
            $config = $this->SocialiteOverridingConfig($provider, $role);////новый конфиг
            $user = Socialite::driver($provider)->setConfig($config)->stateless()->user();
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
       }

        $userCreated = User::firstOrCreate(//ищет запись, по 1 массииву, если нету создает новое с данными из 2х масивов
            [
                'email' => $user->getEmail()
            ],
            [
                'email_verified_at' => Carbon::now(),
                'name' => $user->getName(),
                'status' => true,
            ]
        );
        $userCreated->providers()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $user->getId(),
            ],
            [
                'avatar' => $user->getAvatar()
            ]
        );

        //если не будет ни одной роли то создаст / иначе если роль есть то не создаем новую роль
        if(!$userCreated->hasRole(Role::all()->pluck('name')->toArray())) {
            $userCreated->assignRole($role);
            DefaultService::run($userCreated->id, $role);//дефолтные данные
        }

        $this->user = $userCreated;

        $token = $this->createToken();
        return Json::send($token);
    }

    private function createToken():array
    {
        $success = [...$this->user->toArray()];
        $success['token'] =  $this->user->createToken('LaravelSanctumAuth')->plainTextToken;
        //$success['name'] =  $this->user->name;
        $success['role'] = $this->getMyRole();
        //$success['providers'] = $this->user->providers()->get();//получим отношения соц сетей
        unset($success['roles']);
        return $success;
    }

    private function getMyRole()
    {
        //$roles = $this->user->roles()->get(); //можно и так
        if(isset($this->user)) $roles = $this->user->roles()->get();
        else $roles = auth()->user()->roles()->get();
        //$roles = auth()->user()->roles()->get();

        if(!$roles) return [];
        $roles =  $roles->toArray();
        return $roles[0]['name'];
        return [
            'role_id' => $roles[0]['id'],
            'role_name' => $roles[0]['name'],
        ];
    }

    public function checkRole(string $role):bool|CustomException
    {
        $all_roles_in_database = Role::all()->pluck('name')->toArray();
        if(!in_array($role,$all_roles_in_database)) CustomException::error(1000);
        return true;
    }

    public function getRolesName():array
    {
        return Role::all()->pluck('name')->toArray();
    }

    //Переопределение конфигурации так как у нас много разных callback url нам не подходит стандартная конфигурация
    //этот запрос просто меняет URL callback для переадресации из соц сети
    //$provider vkontakte / $role роль надо создать нам master например
    private function SocialiteOverridingConfig(string $provider, string $role):Object
    {
        $clientId = config('config_socialite.'.$provider.'.client_id');//наш ид по provider - например vkontakte
        $clientSecret = config('config_socialite.'.$provider.'.client_secret');
        //собираем url вида http://localhost/api/v1/auth/login/vkontakte/salon/callback //vkontakte соц сеть
        $redirectUrl = env('URL_CALLBACK')."/api/v1/auth/login/$provider/$role/callback";
        $config = new \SocialiteProviders\Manager\Config($clientId, $clientSecret, $redirectUrl);
        return $config;
    }*/

}
