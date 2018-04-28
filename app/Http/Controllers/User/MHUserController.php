<?php

namespace App\Http\Controllers\User;

use App\mhActivate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MHUserController extends Controller
{
    public function queryView() {
        return view('user/mh/query');
    }

    public function queryCode(Request $request) {
        $queryActivate = $request->get('queryActivate');
        $activate = mhActivate::where('register', $queryActivate)->first();
        $message = "";
        if ($activate == null) {
            $message = '该激活码不存在!';

        } else {
            if (strcmp($activate->UUID, "1") == 0 and $activate->useable == 1) {
                $message = '该激活码未被激活';
            } else if($activate->useable == 0) {
                $message = '该激活码已被冻结';
            } else {
                $message = '该激活码已被激活';
            }
        }
        return response()->json([
            'message' => $message,
        ]);
    }
}
