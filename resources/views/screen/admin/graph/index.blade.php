@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "Main Page" , "url" => route("topic_index_page") ],
    [ "name" => "Graph" , "url" => null ],
];

$monthList = array(
        "",
        "มกราคม", 
        "กุมภาพันธ์", 
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายน",
        "ตุลาคม",
        "พฤศจิกายน",
        "ธันวาคม"
    );

?>


@section('script_header')

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "Graph" , "breadcrumb" => $breadcrumb])

@endcomponent

@endsection


<!-- CONTENT -->

@section('content')

@if (session('alert'))


<div class="alert alert-{{session('status')}} alert-dismissible fade show" role="alert">
    {{ session('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <canvas id="res_chart" width="100%"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <canvas id="res_faculty" width="100%"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <canvas id="res_campus" width="100%"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card shadow p-3">
                    <div class="card-body">
                        <b>ข้อมูลส่งเรื่องมาในระบบ ปี 2022 ในแต่ละเดือน | Information submitted for the year 2022 monthly</b>
                     

                        <div style="padding-bottom: 1%;"></div>
                        <div class="table-responsive">
                            <table class="table table-bordered"  width="100%">
                                <thead>
                                    <tr>
                                        <th >MonthName</th>
                                        <th >All</th>
                                        <th >Research Advisory</th>
                                        <th >Publication Proofreading</th>
                                        <th >Paper Persentation</th>
                                    </tr>
                                </thead>
                                <tbody>     
                                    @foreach ($array_reportYear2022 as $item )
                                    <tr>
                                        <td>{{$monthList[$item['number']]}}</td>
                                        <td>{{$item['value']}}</td>
                                        <td>{{$item['pa_count']}}</td>
                                        <td>{{$item['pubp_count']}}</td>
                                        <td>{{$item['paper_count']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              
            </div>
        </div>
    </div>
</div>


@endsection


@section('script_footer')


<script>
    actionChartRes();


    function actionRandomColor(count) {

        let arrColor = ["#cd84f1", "#575fcf", "#f53b57", "#ffaf40", "#fffa65",
            "#c56cf0", "#ffb8b8", "#ff3838", "#ff9f1a", "#fff200",
            "#32ff7e", "#7efff5", "#18dcff", "#7d5fff", "#4b4b4b",
            "#3ae374", "#67e6dc", "#17c0eb", "#7158e2", "#ef5777",
            "#575fcf", "#4bcffa", "#34e7e4", "#0be881", "#f53b57",
            "#3c40c6", "#0fbcf9", "#ffc048", "#ffdd59", "#ff5e57"
        ]
        let stemp = []
        for (let k = 0; k < count; k++) {
            stemp.push(arrColor[Math.floor(Math.random() * arrColor.length) + 1])
        }
        return stemp;
    }

    function actionChartRes() {

        let itemKey_Name = {!! json_encode($array_keyName) !!};
        let itemKey_Count = {!! json_encode($array_keyCount) !!};


        var ctx = document.getElementById('res_chart').getContext('2d');
        var chart = new Chart(ctx, {

            type: 'bar',
            data: {
                labels: itemKey_Name,
                datasets: [{
                    label: 'จำนวนงานแต่ละประเภท',
                    backgroundColor: '#c7ecee',
                    borderWidth: 1,
                    data:  itemKey_Count
                }]
            },
            options: {
                defaultFontFamily: Chart.defaults.global.defaultFontFamily = "'Prompt'",
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        //-----------------------

        
        let itemfaculty_Name = {!! json_encode($array_facultyName) !!};
        let itemfaculty_Count = {!! json_encode($array_facultyCount) !!};

        var ctx_faculty = document.getElementById('res_faculty').getContext('2d');
        var chart_faculty = new Chart(ctx_faculty, {
        type: 'bar',
        data: {
            labels: itemfaculty_Name,
            datasets: [{
                label: 'จำนวนคณะที่เข้าใช้บริการ',
                backgroundColor: '#c7ecee',
                borderWidth: 1,
                data:  itemfaculty_Count
            }]
        },
        options: {
            defaultFontFamily: Chart.defaults.global.defaultFontFamily = "'Prompt'",
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
        });


        //-----------------------


        let itemcampus_Name = {!! json_encode($array_campusName) !!};
        let itemcampus_Count = {!! json_encode($array_campusCount) !!};

        var ctx_campus = document.getElementById('res_campus').getContext('2d');
        var chart_campus = new Chart(ctx_campus, {
        type: 'bar',
        data: {
            labels: itemcampus_Name,
            datasets: [{
                label: 'จำนวนวิทยาเขตที่เข้าใช้บริการ',
                backgroundColor: '#c7ecee',
                borderWidth: 1,
                data:  itemcampus_Count
            }]
        },
        options: {
            defaultFontFamily: Chart.defaults.global.defaultFontFamily = "'Prompt'",
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
        });



    }


</script>

@endsection