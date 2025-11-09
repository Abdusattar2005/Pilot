<?php

namespace App\Services;

class Json
{
	public static function send(string|int|array|object|null $mess = 'success', int $code = 200)
	{
		return response()->json([
            'error' => false,
            'message' => is_integer($mess) ? trans('messages.'.$mess) : (is_string($mess) ? $mess : (is_array($mess) || is_object($mess) ? 'success' : "Значение пустое")),            
            //'data' => is_array($mess) || is_object($mess) ? $mess : []
            'data' => is_array($mess) || is_object($mess) || is_null($mess)  ? $mess : []
        ], $code,
        [
            'Content-Type' => 'application/json; charset=UTF-8',
            'Charset' => 'utf-8'
        ],

        JSON_UNESCAPED_UNICODE
        );
	}

	public static function errors(string|int|array $mess, int $code = 404)
	{
		return response()->json([
            'error' => true,
            'errors' => is_numeric($mess) ? trans('messages.'.$mess) : $mess
        ], $code,
        [
            'Content-Type' => 'application/json; charset=UTF-8',
            'Charset' => 'utf-8'
        ],

        JSON_UNESCAPED_UNICODE);
	}

        /*public static function message(string|int $mess = 'success', int $code = 200)
    {
        return response()->json([
            //'status' => true,
            'data' => [
                'message' => is_numeric($mess) ? trans('messages.'.$mess) : $mess
                ]
        ], $code,
        [
            'Content-Type' => 'application/json; charset=UTF-8',
            'Charset' => 'utf-8'
        ],

        JSON_UNESCAPED_UNICODE
        );
    }*/

}

