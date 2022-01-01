<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Account;
use App\Model\Researcher;
use App\Model\Topic;
use App\Model\Tracking;

class TrackingController extends Controller
{

    public function actionIndex()
    {
        $model = Tracking::all();
        return view("screen.admin.tracking.index" , ['model' => $model]);
    }

    public function actionCreate(Request $request)
    {
        $model = Tracking::where('name_th', '=', $request->name_th)->count();

        if ($model > 0) {

            return $this->responseRedirectBack("The name is already in the system. ( ชื่อสถานะนี้มีอยู่ในระบบแล้ว ) !", "warning");

        } else {

            $model = new Tracking();
            $model->name_th = $request->name_th;
            $model->name_en = $request->name_en;
            $model->role = $request->role;

            if ($model->save()) {
                return $this->responseRedirectBack("Save the information successfully. (บันทึกข้อมูลเรียบร้อย) !");
            } else {
                return $this->responseRedirectBack("Can't save data Please try again. (ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง )!", "warning");
            }
        }
    }

    public function actionView($id)
    {
        $model = Tracking::find($id);

        if($model){
            return view("screen.admin.tracking.update", ["model" => $model]);
        }else{
            return $this->responseRedirectBack("No data found ID = $id", "warning");
        }   
    }

    public function actionUpdate(Request $request)
    {

        $model = Tracking::find($request->id);

        if($model){

            $model->name_th = $request->name_th;
            $model->name_en = $request->name_en;
            $model->role = $request->role;

            $model->save();

            return $this->responseRedirectBack("Save the information successfully. (บันทึกข้อมูลเรียบร้อย) !");

        }else{

            return $this->responseRedirectBack("No data found ID = $request->id", "warning");

        }
    }

    public function actionDelete($id)
    {
        $model = Tracking::find($id);

        if($model){

            $checkedData = Topic::where('progress' , '=' , $model->id)->count();

            if($checkedData != 0){
                return $this->responseRedirectBack("delete [ id : $id ] Tracking failed , have data used !", 'warning');
            }

            $model->delete();


            return $this->responseRedirectBack("delete [ id : $id ] tracking success !");


        }else{
            
            return $this->responseRedirectBack("No data found ID = $id", "warning");

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
