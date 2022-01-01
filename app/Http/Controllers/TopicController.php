<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Account;
use App\Model\Answer;
use App\Model\Researcher;
use App\Model\Topic;

class TopicController extends Controller
{

    public function actionIndex()
    {
        $model = Topic::where("create_by" , '=' , session('username')  )->get();
        return view("screen.topic.index", ["model" => $model]);
    }

    public function actionDelete($id)
    {
        $model = Topic::find($id);

        if($model){

            if(session('role') != "admin"){
                if($model->create_by != session('username')){
                    return $this->responseRedirectBack("delete [ id : $id ] question failed !", 'warning');
                }
            }

       
            foreach (glob(public_path("upload/$model->code/*")) as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
      
            if (is_dir(public_path("upload/$model->code"))) {
                rmdir(public_path("upload/$model->code"));
            }


            Answer::where("topic_id" , '=' , $model->id)->delete();
            $model->delete();

            return $this->responseRedirectBack("delete [ id : $id ] question success !");
        }else{
            return $this->responseRedirectBack("delete [ id : $id ] question failed !", 'warning');
        }
    }

    public function actionCreate(Request $request)
    {
        if ($request->isMethod('get')) {
            return view("screen.topic.create");
        }

        try {
            $fileName = null;
            $codefolder = $this->generateRandomString(18);
            $this->actionCreateFolder($codefolder);

            $model = new Topic();

            if ($request->file("file")) {
                if ($request->file("file")->getSize() > 31457280) {
                    return $this->responseRedirectBack("size file [ > ]  30 mb resize file upload", "warning");
                }

                $fileName = $this->generateRandomString() . "."  . $request->file("file")->getClientOriginalExtension();
                if (!$request->file("file")->move(public_path("upload/$codefolder"), $fileName)) {
                    return $this->responseRedirectBack("upload file failed !", 'warning');
                }
            }

            $model->name = $request->name;
            $model->keyword = $request->keyword;
            $model->progress = 0;
            $model->status = 0;
            $model->content = $request->content;
            $model->code = $codefolder;
            $model->file = $fileName;
            $model->date_start = $request->date_start;
            $model->date_end = $request->date_end;
            $model->email = session('email');
            $model->create_by = session('username');

            if ($model->save()) {
                return $this->responseRedirectRoute("topic_index_page", "create question success !");
            } else {
                return $this->responseRedirectBack("create question failed !", 'warning');
            }


        } catch (\PDOException $th) {
            return $th->getMessage();
        }
    }


    public function actionView($id)
    {
        $model = Topic::find($id);
        if($model){

            if(session('role') != "admin"){
                if($model->create_by != session('username')){
                    return $this->responseRedirectBack("You do not have access question !", 'warning');
                }
            }

            $ansData = Answer::where("topic_id" , "=" , $model->id)->get();

            return view("screen.topic.view", ['model' => $model , "ansData" => $ansData]);
        }else{
            return $this->responseRedirectBack("not data question !", 'warning');
        }
       
    }


    public function actionTrack($id)
    {
        $model = Topic::find($id);

        if ($model) {

            if(session('role') != "admin"){
                if($model->create_by != session('username')){
                    return $this->responseRedirectBack("You do not have access question !", 'warning');
                }
            }


            return view("screen.topic.tags", ["model" => $model]);
        } else {
            return $this->responseRedirectBack("No data found ID = $id", "warning");
        }
    }

    public function actionTracking(Request $request)
    {
        $model = Topic::find($request->id);

        if($model){

            $model->progress = $request->tracking_status;
            $model->save();

            return $this->responseRedirectBack("Update status ID = $request->id");

        }else{
            return $this->responseRedirectBack("No data found ID = $request->id", "warning");
        }
    }

    public function actionCreateFolder($code)
    {
        $destinationPath = public_path("upload/$code");
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
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
