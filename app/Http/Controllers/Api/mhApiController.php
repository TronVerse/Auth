<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\mhActivate;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DateTime;

class mhApiController extends Controller
{
    public function queryStatus(Request $request) {
        $activate = mhActivate::where('UUID', $request->get('UUID'))->first();
        if ($activate == null) {
            return response()->json([
                'result' => 'fail',
                'message' => 'UUID not found',
                'statusCode' => '404'
            ]);
        }
        if ($activate->useable == 0) {
            return response()->json([
                'result' => 'fail',
                'message' => 'code has been freezed',
                'statusCode' => '403'
            ]);
        } else {
            return response()->json([
                'result' => 'success',
                'message' => 'code check success',
                'statusCode' => '200'
            ]);
        }
    }

    public function activeCode(Request $request) {
        $activate = mhActivate::where('register', $request->get('activate'))->first();
        if ($activate == null) {
            return response()->json([
                'result' => 'fail',
                'message' => 'activate not found',
                'statusCode' => '404'
            ]);
        }
        if (strcmp($activate->UUID, "1") == 0 and $activate->useable == 1) {
            $dt = new DateTime();
            $activate->UUID = $request->get('UUID');
            $activate->activetime = $dt->format('Y-m-d H:i:s');
            $activate->save();
            return response()->json([
                'result' => 'success',
                'message' => 'code active success',
                'statusCode' => '200'
            ]);
        } else if(strcmp($activate->UUID, "1") != 0) {
            return response()->json([
                'result' => 'fail',
                'message' => 'code has been actived',
                'statusCode' => '403'
            ]);
        } else if($activate->useable == 0){
            return response()->json([
                'result' => 'fail',
                'message' => 'code has been freezed',
                'statusCode' => '405'
            ]);
        }
    }
}
