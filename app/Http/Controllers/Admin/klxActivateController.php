<?php

namespace App\Http\Controllers\Admin;
use App\klxActivate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\userAuthority;
use App\Http\Requests;
use DateTime;
use App\Http\Controllers\Controller;

class klxActivateController extends Controller
{
    public function index() {
        $user = Auth::user();
        $activates = null;
        $activates = klxActivate::where('creator', $user->id)->get();
        $activatesPage = klxActivate::where('creator', $user->id)->latest()->paginate(15);
        $activateSum = 0;
        $freezeSum = 0;
        $activeSum = 0;
        foreach($activates as $activate) {
            $activateSum += 1;
            if ($activate->useable == 0) $freezeSum += 1;
            if (strcmp($activate->UUID, '1') != 0) $activeSum += 1;
        }
        return view('admin/wsklx/index', [
            'activates' => $activatesPage,
            'isAdmin' => Auth::user()->administrator,
            'activateSum' => $activateSum,
            'freezeSum' => $freezeSum,
            'activeSum' => $activeSum
        ]);
    }

    public function massdeleteView() {
        return view('admin/wsklx/massdelete');
    }

    public function massdeletePreview(Request $request) {
        $massActivates = trim($request->get("massdeleteActivate"));
        $deleteActivates = explode("\r\n",$massActivates);
        $info = array();
        foreach ($deleteActivates as $curActivate) {
            $message = null;
            $activate = klxActivate::where('register', $curActivate)->first();
            if ($activate == null) {
                $message = "激活码不存在";
            } else {
                if (strcmp($activate->UUID, "1") == 0 and $activate->useable == 1) {
                    $message = "激活码未激活";
                } else if(strcmp($activate->UUID, "1") != 0) {
                    $message = "激活码已被激活";
                } else if($activate->useable == 0){
                    $message = "激活码已被冻结";
                }
            }
            array_push($info, [
                'activate' => $curActivate,
                'message' => $message,
            ]);
        }
        return view('admin/wsklx/deletePreview')->with([
            'info' => $info,
        ]);
    }

    public function massdeleteActivate (Request $request) {
        $massActivates = $request->get("massdeleteActivate");
        $success = true;
        $errActivate = null;
        foreach ($massActivates as $deleteActivate) {
            $curActivate = klxActivate::where('register', $deleteActivate)->first();
            if($curActivate == null or $curActivate->delete() == false) {
                $success = false;
                $errActivate = $deleteActivate;
                break;
            }
        }
        if ($success == false) {
            return redirect('/admin/wsklx')->with('message', '批量删码错误('.$errActivate.')!');
        } else {
            return redirect('/admin/wsklx')->with('message', '批量删码成功!');
        }

    }

    public function createView() {
        return view('admin/wsklx/create');
    }

    public function freezeView() {
        return view('admin/wsklx/freeze');
    }

    public function registerView() {
        return view('auth/register');
    }

    public function agentView() {
        $user = Auth::user();
        $activates = null;
        if ($user->administrator == 0) {
            return redirect('/admin/wsklx')->with('message', '您没有足够的权限!');
        } else {
            $info = array();
            $agents = User::where('administrator', '0')->get();
            foreach ($agents as $agent) {
                $activateSum = 0;
                $freezeSum = 0;
                $activeSum = 0;
                $curID = $agent->id;
                $curActivates = klxActivate::where('creator', $curID)->get();
                foreach($curActivates as $activate) {
                    $activateSum += 1;
                    if ($activate->useable == 0) $freezeSum += 1;
                    if (strcmp($activate->UUID, '1') != 0) $activeSum += 1;
                }
                array_push($info, [
                    'agentName' => $agent->name,
                    'activateSum' => $activateSum,
                    'activeSum' => $activeSum,
                    'freezeSum' => $freezeSum,
                ]);
            }
            return view('admin/wsklx/agentStatus')->with('info', $info);
        }
    }

    public function freezeActivate(Request $request) {
        $freezeActivate = $request->get('freezeActivate');
        $activate = klxActivate::where('register', $freezeActivate)->first();
        if ($activate == null) {
            return redirect('/admin/wsklx')->with('message', '该激活码不存在!');
        } else {
            $activate->useable = 0;
            $activate->save();
            return redirect('/admin/wsklx')->with('message', '冻结成功!');
        }
    }

    public function unfreezeActivate(Request $request) {
        $unfreezeActivate = $request->get('unfreezeActivate');
        $activate = klxActivate::where('register', $unfreezeActivate)->first();
        if ($activate == null) {
            return redirect('/admin/wsklx')->with('message', '该激活码不存在!');
        } else {
            $activate->useable = 1;
            $activate->save();
            return redirect('/admin/wsklx')->with('message', '解冻成功!');
        }
    }

    public function getActivate(Request $request) {
        $curUser =  Auth::user();
        $sumAmount = userAuthority::where('userid', $curUser->id)->first();
        $amount = $request->get('amount');
        if ($sumAmount->klxAmount >= $amount) {
            $sumAmount->klxAmount -= $amount;
            $sumAmount->save();
            $activates = array();
            for ($i = 1; $i <= $amount; $i++) {
                $register = 'CJZC'.$this->getRandChar(14);
                array_push($activates, $register);
                $InsData = [
                    'register' => $register,
                    'UUID' => '1',
                    'creator' => $curUser->id,
                    'useable' => 1,
                    'usetime' => 9999
                ];
                $class = klxActivate::create($InsData);
            }
            return view('admin/wsklx/getActivates')->with('results', $activates);
        } else {
            return redirect('/admin/wsklx')->with('message', '可生成激活码数量不足!只有'.$sumAmount->klxAmount.'个');
        }
    }

    function getRandChar($length) {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }

    public function destroy($id) {
        klxActivate::find($id)->delete();
        return redirect('/admin/wsklx')->with('message', '删除成功!');
    }

    public function queryView() {
        return view('/admin/wsklx/query');
    }

    public function queryActivate(Request $request) {
        $queryActivate = $request->get('queryActivate');
        $activate = klxActivate::where('register', $queryActivate)->first();
        if ($activate == null) {
            return redirect('/admin/wsklx/query')->with('message', '该激活码不存在!');
        } else {
            $isActivate = false;
            $agent = User::where('id', $activate->creator)->first();
            $message = "";
            if (strcmp($activate->UUID, "1") == 0 and $activate->useable == 1) {
                $message = '该激活码未被激活';
            } else if($activate->useable == 0) {
                $message = '该激活码已被冻结';
            } else {
                $isActivate = true;
                $message = '该激活码已被激活';
            }
            return view('/admin/wsklx/queryResult')->with([
                'activate' => $activate,
                'message' => $message,
                'isActivate' => $isActivate,
                'agentName' => $agent->name,
                'isAdministrator' => Auth::user()->administrator
            ]);
        }
    }

    protected function createAgent(Request $request)
    {
        $passwd = $request->get('password');
        $com_passwd = $request->get('password_confirmation');
        if (strcmp($passwd, $com_passwd) != 0) {
            return redirect('/admin/wsklx')->with('message', '两次密码不一致!');
        }
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($passwd),
            'administrator' => 0,
        ]);

        $createID = User::all()->last()->id;
        userAuthority::create([
            'userid' => $createID,
            'klxAmount' => $request->get('activateCnt')
        ]);
        return redirect('/admin/wsklx')->with('message', '创建成功!');
    }
}
