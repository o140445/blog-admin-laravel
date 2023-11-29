<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function jsonSuccess($data = [], $msg = "ok", $status = 0)
    {
        return response()->json(['code' => $status, 'msg' => $msg, 'data' => $data], 200);
    }

    public function jsonError($msg = "error", $status = -1)
    {
        return response()->json(['code' => $status, 'msg' => $msg], 400);
    }
}
