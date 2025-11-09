<?php

namespace App\Exceptions;
use Exception;

class CustomException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public static function error(string|int $rutext = 0, int $code = 404)
    {
        $messages_text = is_numeric($rutext) ? trans('messages.'.$rutext) : $rutext;
        $messages = json_encode(
            [
                'message' => $messages_text,
                'code' => is_numeric($rutext) ? $rutext : 0
        ]);

        throw new CustomException($messages, $code);
    }

    public function render($request)
    {
        $errors = json_decode($this->getMessage());
        return response()->json([
            'error' => true,
            'code' => $errors->code,
            'message' => $errors->message,
        ],

        $this->getCode(),

        [
            'Content-Type' => 'application/json; charset=UTF-8',
            'Charset' => 'utf-8'
        ],

        JSON_UNESCAPED_UNICODE);
    }
}
