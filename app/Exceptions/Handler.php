<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Auth\AuthenticationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Broadcasting\BroadcastException;
use League\Flysystem\FileNotFoundException;
use TypeError;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [        
        CustomException::class,// не пишем логи и не считаем ошибками мои исключения        
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
public function register()
    {
        /*$this->renderable(function (TypeError $e, $request) {
            //if ($request->is('api/*')) {               
                return response()->json([
                    //'errors' => trans('messages.1000') //Что-то пошло не так
                            'error' => true,
                            'code' => 1010,
                            'message' => trans('messages.1010'),
                ], 400,
                [
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'Charset' => 'utf-8'
                ],

                JSON_UNESCAPED_UNICODE);
            //}
        });*/

        // "message": "Too Many Attempts.",
        $this->renderable(function (ThrottleRequestsException $e, $request) {
                return response()->json([                    
                            'error' => true,
                            'code' => 0,
                            'message' => 'Too Many Attempts',
                ], 429,
                [
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'Charset' => 'utf-8'
                ],

                JSON_UNESCAPED_UNICODE);
            //}
        });
        
        $this->renderable(function (FileNotFoundException $e, $request) {
            //if ($request->is('api/*')) {               
                return response()->json([
                    //'errors' => trans('messages.1000') //Что-то пошло не так
                            'error' => true,
                            'code' => 1007,
                            'message' => trans('messages.1007'),
                ], 404,
                [
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'Charset' => 'utf-8'
                ],

                JSON_UNESCAPED_UNICODE);
            //}
        });


                //соркет проблемы
        //Pusher error: cURL error 7: Failed to connect to voditelda.com port 6001: Connection refused (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://voditelda.com:6001/apps/ID_77789/events?auth_key=KEY_111589&auth_timestamp=1657974131&auth_version=1.0&body_md5=40d04d413ce7cc9be677175ba4282c07&
        $this->renderable(function (BroadcastException $e, $request) {
            //if ($request->is('api/*')) {
            //return false;
                Log::error($request, [
                    'REQUEST_URI' => $_SERVER['REQUEST_URI'],
                    'user_id' => auth()->user()->id ?? null,
                    'method'=>$request->method(),
                    'messages' => $e->getMessage(),
                ]);

                return response()->json([
                    //'errors' => trans('messages.1000') //Что-то пошло не так
                                                'error' => true,
                            'code' => 1006,
                            'message' => trans('messages.1006'),
                ], 404,
                [
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'Charset' => 'utf-8'
                ],

                JSON_UNESCAPED_UNICODE);
            //}
        });


        //если не нашли в БД или открыли не сущ страницу
        $this->renderable(function (NotFoundHttpException $e, $request) {
            //if ($request->is('api/*')) {
                Log::error($request, [
                    'REQUEST_URI' => $_SERVER['REQUEST_URI'],
                    //'user_id' => auth()->user()->id ?? null,
                    'method'=>$request->method(),
                    'messages' => $e->getMessage(),
                ]);

                return response()->json([
                    //'errors' => trans('messages.1000') //Что-то пошло не так
                                                'error' => true,
                            'code' => 1000,
                            'message' => trans('messages.1000'),
                ], 404,
                [
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'Charset' => 'utf-8'
                ],

                JSON_UNESCAPED_UNICODE);
            //}
        });

        //если юзеру запрещен доступ к обновлению записи/ например когда мы запрешаем в валдиции NotesUpdateRequest метод  authorize()
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            //if ($request->is('api/*')) {

                Log::info($request, [
                    'REQUEST_URI' => $_SERVER['REQUEST_URI'],
                    'user_id' => auth()->user()->id ?? null,
                    'method'=>$request->method(),
                    'messages' => $e->getMessage(),
                ]);

                return response()->json([
                    //'errors' => trans('messages.1001') //Вы не можете совершить данное действие
                            'error' => true,
                            'code' => 1001,
                            'message' => trans('messages.1001'),
                ], 404,
                [
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'Charset' => 'utf-8'
                ],

                JSON_UNESCAPED_UNICODE);
            //}
        });

                //метод
                $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
                    //if ($request->is('api/*')) {

                        Log::info($request, [
                            'REQUEST_URI' => $_SERVER['REQUEST_URI'],
                            'user_id' => auth()->user()->id ?? null,
                            'method'=>$request->method(),
                            'messages' => $e->getMessage(),
                        ]);

                        return response()->json([
                            //'errors' => trans('messages.1002')
                            'error' => true,
                            'code' => 1002,
                            'message' => trans('messages.1002'),
                        ], 404,
                        [
                            'Content-Type' => 'application/json; charset=UTF-8',
                            'Charset' => 'utf-8'
                        ],

                        JSON_UNESCAPED_UNICODE);
                    //}
                });
                                //токен
                $this->renderable(function (UnauthorizedHttpException $e, $request) {
                    //if ($request->is('api/*')) {

                        Log::info($request, [
                            'REQUEST_URI' => $_SERVER['REQUEST_URI'],
                            'user_id' => auth()->user()->id ?? null,
                            'method'=>$request->method(),
                            'messages' => $e->getMessage(),
                        ]);

                        return response()->json([                           
                            //'errors' => 'Token has expired' //Вы не можете совершить данное действие
                            'error' => true,
                            'code' => 401,
                            'message' => 'Token has expired'
                        ], 401,
                        [
                            'Content-Type' => 'application/json; charset=UTF-8',
                            'Charset' => 'utf-8'
                        ],

                        JSON_UNESCAPED_UNICODE);
                    //}
                });

                //вместо {"message":"Unauthenticated."}
                $this->renderable(function (AuthenticationException $e, $request) {                   

                        Log::info($request, [
                            'REQUEST_URI' => $_SERVER['REQUEST_URI'],
                            'user_id' => auth()->user()->id ?? null,
                            'method'=>$request->method(),
                            'messages' => $e->getMessage(),
                        ]);

                        return response()->json([                           
                            //'errors' => 'Token Error'
                            'error' => true,
                            'code' => 401,
                            'message' => 'Token Error'
                        ], 401,
                        [
                            'Content-Type' => 'application/json; charset=UTF-8',
                            'Charset' => 'utf-8'
                        ],

                        JSON_UNESCAPED_UNICODE);                    
                });

                                //нету нужной роли
                $this->renderable(function (UnauthorizedException $e, $request) {                   

                        Log::info($request, [
                            'REQUEST_URI' => $_SERVER['REQUEST_URI'],
                            'user_id' => auth()->user()->id ?? null,
                            'method'=>$request->method(),
                            'messages' => $e->getMessage(),
                        ]);

                        return response()->json([                           
                            //'errors' => trans('messages.1003')
                            'error' => true,
                            'code' => 1003,
                            'message' => trans('messages.1003'),
                        ], 401,
                        [
                            'Content-Type' => 'application/json; charset=UTF-8',
                            'Charset' => 'utf-8'
                        ],

                        JSON_UNESCAPED_UNICODE);                    
                });
                
    }
}
