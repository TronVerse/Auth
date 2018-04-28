<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\klxActivate;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function queryView() {
        return view('user/wsklx/query');
    }

    public function queryCode(Request $request) {
        $queryActivate = $request->get('queryActivate');
        $activate = klxActivate::where('register', $queryActivate)->first();
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
        return redirect('user/query')->with('message', $message);
    }
}
