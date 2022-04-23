<?php

namespace App\Http\Controllers;

use App\Model\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Phattarachai\LineNotify\Facade\Line;

class AuthenticationController extends Controller
{

    public function actionHomeLogin()
    {
        return view("auth.login");
    }

    public function actionHomeRMUTILogin()
    {

        /*
        ทดลอง login rmuti จริงๆแล้วมันไม่เหมาะเลย แต่ต้องมี เคสตัวอย่างที่มันไม่เหมาะกับงาน login rmuti ถึงจะเอาไปพูดได้ว่าไม่เหมาะยังไง tdotdev 26/12/2021
        */

        if (!Cookie::get('OAUTH2_login_info')) {
            header("location: " . "https://mis-ird.rmuti.ac.th/sso/auth/login?url=" . route("login_rmuti_data"));
            exit(0);
        } else {
            return redirect()->route("login_rmuti_data");
        }
    }

    public function actionLoginTest()
    {

        $model = Account::where('uid', '=', 'jirayu.co')->first();

        if ($model) {

            session(['auth' => true]);
            session(['username' => $model->uid]);
            session(['card_id' => $model->card_id]);
            session(['fullname' => $model->firstname_th . " " . $model->lastname_th]);
            session(['email' => $model->email]);
            session(['role' => "admin"]);
            session(['rmutilogin' => true]);

            // จากใน Controller หรือที่อื่น ๆ
            Line::send('ทดสอบส่งข้อความ');

            return redirect()->route("dashboard_index_page");
        } else {
            return "error test";
        }
    }

    public function actionLoginRmuti(Request $request)
    {
        if (isset($_COOKIE['OAUTH2_login_info'])) {

            $data = json_decode($_COOKIE['OAUTH2_login_info']);

            // $admin = [
            //     "jirayu.co",
            //     "arunrak.de"
            // ];

            $admin = [
                "jirayu.co",
                "martha.er",
            ];

            try {

                $model = Account::where("uid", '=', $data->uid)->first();

                if (!$model) {

                    $model = new Account();
                    $model->uid = $data->uid;
                    $model->card_id = isset($data->personalId) ? $data->personalId : "";
                    $model->prename = isset($data->prename) ? $data->prename : "";
                    $model->firstname_th = isset($data->firstNameThai) ? $data->firstNameThai : "";
                    $model->lastname_th = isset($data->lastNameThai) ? $data->lastNameThai : "";
                    $model->firstname_en = isset($data->cn) ? $data->cn : "";
                    $model->lastname_en = isset($data->sn) ? $data->sn : "";
                    $model->department = isset($data->department) ? $data->department : "";
                    $model->faculty = isset($data->faculty) ? $data->faculty : "";
                    $model->position = isset($data->title) ? $data->title : "";
                    $model->campus = isset($data->campus) ? $data->campus : "";
                    $model->email = isset($data->mail) ? $data->mail : "";
                    $model->save();
                }

                if (in_array($data->uid, $admin)) {

                    session(['auth' => true]);
                    session(['username' => $data->uid]);
                    session(['card_id' => $data->personalId]);
                    //session(['fullname' => $data->firstNameThai . " " . $data->lastNameThai]);
                    session(['fullname' => $data->cn . " " . $data->sn]);
                    session(['email' => $data->mail]);
                    session(['role' => "admin"]);
                    session(['rmutilogin' => true]);

                    return redirect()->route("dashboard_index_page");
                } else {


                    session(['auth' => true]);
                    session(['username' => $data->uid]);
                    session(['card_id' => $data->personalId]);
                    //session(['fullname' => $data->firstNameThai . " " . $data->lastNameThai]);
                    session(['fullname' => $data->cn . " " . $data->sn]);
                    session(['email' => $data->mail]);
                    session(['role' => "user"]);
                    session(['rmutilogin' => true]);

                    return redirect()->route("topic_index_page");
                }
            } catch (\PDOException $th) {
                return $this->responseRedirectRoute("login_page", "error login", "danger");
            }
        } else {

            header("location: " . "https://mis-ird.rmuti.ac.th/sso/auth/login?url=" . route("login_rmuti_data"));
            exit(0);
        }
    }

    public function actionLogout()
    {
        session()->forget(['auth', 'id', 'username', 'fullname', 'role']);

        if (session("rmutilogin")) {

            session()->forget('rmutilogin');

            return redirect('https://mis-ird.rmuti.ac.th/sso/auth/logout?url=' . route("login_page"));
        } else {
            return redirect()->route("login_page");
        }
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
