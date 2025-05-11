<?php

namespace App\Traits;

trait ApiTrait{

    public function success($msg , $status , $data = [])
    {
        return response()->json([
            'message' => $msg,
            'status' => $status,
            'data' => $data
        ], $status);
    }

    public function failed($msg , $status , $data = [])
    {
        return response()->json([
            'message' => $msg,
            'status' => $status,
            'data' => $data
        ], $status);
    }

}
