<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Account;
use App\Model\Researcher;

class AuthenticationController extends Controller
{

    public function actionHomeLogin()
    {
        return view("auth.login");
    }

    public function actionHomeRMUTILogin()
    {
        session(['auth' => true]);
        session(['id' => 1]);
        session(['username' => "jirayu.co"]);
        session(['fullname' => "jirayu chiaowet"]);
        session(['role' => "admin"]);
        session(['rmutilogin' => true]);

        return redirect()->route("topic_index_page");
    }

    public function actionLogout()
    {
        session()->forget(['auth' , 'id' , 'username' , 'fullname' , 'role']);
        return redirect()->route("login_page"); 
    }

    protected function responseRedirectBack($message, $status = "success", $alert = true)
    {
        //primary , success , danger , warning
        return redirect()->back()->with(["message" => $message, "status" => $status, "alert" => $alert]);
    }

    protected function responseRedirectRoute($route, $message, $status = "success", $alert = true)
    {
        //primary , success , danger , warning
        return redirect()->route($route)->with(["message" => $message, "status" => $status, "alert" => $alert]);
    }


    protected function responseRequest($data, $bypass = true,  $status = "success")
    {
        return response()->json(['bypass' => $bypass,  'status' => $status, 'data' => $data], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header("Access-Control-Allow-Headers", "Authorization, Content-Type")
            ->header('Access-Control-Allow-Credentials', ' true');
    }
}
