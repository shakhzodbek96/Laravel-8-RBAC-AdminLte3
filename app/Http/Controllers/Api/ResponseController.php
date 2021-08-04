<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;

class ResponseController
{
    public static function successResponse($data)
    {
        return [
            'status' => true,
            'result' => $data
        ];
    }

    public function validationError($validation)
    {
        return [
            'status' => false,
            'error' => [
                'message' => $validation->errors()->first()
            ]
        ];
    }

    public static function errorResponse($message)
    {
        if (is_array($message)) $message = self::getErrorMessageFromResponse($message);

        return [
            'status' => false,
            'error' => [
                'message' => $message
            ]
        ];
    }

    public static function authFailed()
    {
        return [
            'status' => false,
            'error' => [
                'message' => "Authorization failed!"
            ]
        ];
    }

    public function errorMethodUndefined($method = '')
    {
        return [
            'status' => false,
            'error' => [
                'message' => 'Метод '.$method.' не найден'
            ]
        ];
    }

    /**
     * @param array $response
     * @return string $message of error
     */
    public static function getErrorMessageFromResponse(array $response):string
    {
        # initial set default info message
        $message = "Undefined error: ".json_encode($response);

        # find error message
        if (isset($response['error']))
        {
            if (isset($response['error']['message']))
            {
                if (is_array($response['error']['message'])) $message = array_shift($response['error']['message']);
                else $message = $response['error']['message'];
            }
        }
        return $message;
    }


    public function validate(array $params, array $rules)
    {
        $validate = Validator::make($params,$rules);

        if ($validate->fails())
        {
            return self::validationError($validate);
        }

        return true;
    }
}
