<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Account;
use App\Model\Researcher;
use App\Model\Topic;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{

    public function actionIndex()
    {

        $keywordList = Topic::groupBy('keyword')->select('keyword', DB::raw('count(*) as total'))->get();

        $array_keyName = [];
        $array_keyCount = [];

        foreach ($keywordList as $key => $el) {
            $itemName = "";

            if ($el->keyword == 1) {
                $itemName = "Research Advisory";
            } else if ($el->keyword == 2) {
                $itemName = "Publication Proofreading";
            } else {
                $itemName = "Paper Persentation";
            }

            array_push($array_keyName, $itemName);
            array_push($array_keyCount, $el['total']);
        }

        // ------------------------------------ แบ่งคณะ


        $array_facultyName = [];
        $array_facultyCount = [];

        $facultyList = Account::groupBy('faculty')->select('faculty', DB::raw('count(*) as total'))->get();

        foreach ($facultyList as $key => $el) {

            array_push($array_facultyName, $el['faculty']);
            array_push($array_facultyCount, $el['total']);
        }

        // ------------------------------------ แบ่งคณะ END

        // ------------------------------------ แบ่งวิทยาเขต


        $array_campusName = [];
        $array_campusCount = [];

        $campusList = Account::groupBy('campus')->select('campus', DB::raw('count(*) as total'))->get();

        foreach ($campusList as $key => $el) {

            array_push($array_campusName, $el['campus']);
            array_push($array_campusCount, $el['total']);
        }

        // ------------------------------------ แบ่งวิทยาเขต END


        // ------------------------------------ ข้อมูลแต่ละปี มีผู้ส่งคำขอในแต่ละเดือนกี่คน

        /** note dev 04-12-202
         * เขียนแบบนี้ไปก่อนขี่เกียจเขียน loop ให้มันขึ้น เจนทุกปีทุกเดือน *** งานรีบ
         * 
         */

        $array_reportYear2022 = [];
        $PaCount = 0;
        $PubP = 0;
        $Paper = 0;

        for ($i = 1; $i <= 12; $i++) {
            $PaCount = 0;
            $PubP = 0;
            $Paper = 0;

            $dataReportList2022 = Topic::select('id', 'keyword', 'create_at')->whereYear('create_at', '=', 2022)->whereMonth('create_at', $i)->get();
            foreach ($dataReportList2022 as  $el) {

                if ($el->keyword == 1) {
                    $PaCount++;
                } else if ($el->keyword == 2) {
                    $PubP++;
                } else {
                    $Paper++;
                }
            }

            
            array_push($array_reportYear2022, [
                "number" => $i,
                "value" => $PaCount + $PubP + $Paper,
                "pa_count" => $PaCount,
                "pubp_count" => $PubP,
                "paper_count" => $Paper,
            ]);
        }

        return view("screen.admin.graph.index", [
            "array_keyName" => $array_keyName,
            "array_keyCount" => $array_keyCount,
            "array_facultyName" => $array_facultyName,
            "array_facultyCount" => $array_facultyCount,
            "array_campusName" => $array_campusName,
            "array_campusCount" => $array_campusCount,
            "array_reportYear2022" => $array_reportYear2022
        ]);
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
