<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function errorRes($message, $code = 400)
    {
        Log::error("An error while updating note. response: " . $note);
        return json_encode([
            'status' => false,
            'message' => $message,
            'code' => $code
        ]);
    }

    public function successRes($message, $data = [], $code = 200)
    {
        return json_encode([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'code' => $code
        ]);
    }
}
