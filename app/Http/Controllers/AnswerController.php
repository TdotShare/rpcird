<?php

namespace App\Http\Controllers;

use App\Model\Answer;
use App\Model\Topic;
use Illuminate\Http\Request;

class AnswerController extends Controller
{

    public function actionCreate(Request $request)
    {

        $topicData = Topic::find($request->topic_id);
        
        if($topicData){

            $data = $request->all();

            $fileName = null;

            if ($request->file("file")) {
                if ($request->file("file")->getSize() > 31457280) {
                    return $this->responseRedirectBack("size file [ > ]  30 mb resize file upload", "warning");
                }

                $fileName = $this->generateRandomString() . "."  . $request->file("file")->getClientOriginalExtension();
                if (!$request->file("file")->move(public_path("upload/$topicData->code"), $fileName)) {
                    return $this->responseRedirectBack("upload file failed !", 'warning');
                }
            }

            $data['email'] = session('email');
            $data['user_by'] = session('username');
            $data['file'] = $fileName;

            if(Answer::create($data)){
                return $this->responseRedirectBack('create answer success !');
            }else{
                return $this->responseRedirectBack('create answer failed !' , 'warning');
            }

        }else{
            return $this->responseRedirectBack('ไม่พบหัวข้อที่จะส่งคำตอบ !' , 'warning');
        }

    }

    public function actionDelete($id)
    {
        $ansData = Answer::find($id);

        if($ansData){
            try {
                if($ansData->file){
                    $model = Topic::find($ansData->topic_id);

                    if (is_file(public_path("upload/$model->code/$ansData->file"))) {
                        unlink(public_path("upload/$model->code/$ansData->file"));
                    }
                }
                $ansData->delete();
                return $this->responseRedirectBack('delete answer success !');
            } catch (\PDOException $th) {
                return $this->responseRedirectBack($th->getMessage() , 'danger');
            }
        }else{
            return $this->responseRedirectBack('delete answer failed !' , 'warning');
        }
    }

    function generateRandomString($length = 15)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
