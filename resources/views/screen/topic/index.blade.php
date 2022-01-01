@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "Main Page" , "url" => route("topic_index_page") ],
    [ "name" => "Question To Me" , "url" => null ],
];

$keywordItem = [
    "Research Advisory",
    "Publication Proofreading",
    "Paper Presentation"
];

?>


@section('script_header')


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "Question To Me" , "breadcrumb" => $breadcrumb])

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

<a href={{route('topic_create_page')}}><button class="btn btn-primary"><i class="fas fa-plus"></i> Add Question</button></a>

<div style="padding-block: 1%;"></div>

<div class="row">
    <div class="col-md-4">
        <ul class="list-group border">
            <li class="list-group-item">Question name   - ชื่อคำถาม</li>
            <li class="list-group-item">Keyword         - ประเภทงานที่ส่ง</li>
            <li class="list-group-item">Answer Count    - จำนวนคำตอบ</li>
            <li class="list-group-item">Date Posted     - วันที่ตั้งคำถาม</li>
            <li class="list-group-item">Tracking Status - สถานะการติดตาม</li>
        </ul>
    </div>
</div>


<div style="padding-block: 1%;"></div>

<div class="card shadow p-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Question name</th>
                        <th scope="col">Keyword</th>
                        <th scope="col">Answer Count</th>
                        <th scope="col">Date Posted</th>
                        <th scope="col">Tracking Status</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $index => $item )

                    @php
                        $ts_text = "";
                       if($item->progress != 0){
                            $ts_model = \App\Model\Tracking::find($item->progress);
                            $ts_text = $ts_model->name_en;
                        }
                    @endphp
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td><a href={{route("topic_view_page" , ["id" => $item->id])}}>{{$item->name}}</a></td>
                        <td>{{$keywordItem[$item->keyword - 1]}}</td>
                        <td>{{ App\Model\Answer::where('topic_id' , '=' , $item->id)->count() }}</td>
                        <td>{{$item->create_by}}</td>
                        <td>
                            @if ($item->progress == 0)
                                Wait for the staff to read it
                            @else
                                  {{$ts_text}}
                            @endif
                            
                        </td>
                        <td><a href={{route("topic_view_page" , ["id" => $item->id])}}> <button class="btn btn-block btn-primary"><i class="fas fa-eye"></i> View</button></a></td>
                        <td>@if ($item->progress != 0) <a href={{route("topic_track_page" , ["id" => $item->id])}}> <button class="btn btn-block btn-primary"><i class="fas fa-tags"></i> Tracking</button></a> @endif</td>
                        <td><a onclick="return confirm('delete confirm ?');" href={{route("topic_delete_data" , ["id" => $item->id])}}><button class="btn btn-block btn-danger"><i class="fas fa-trash-alt"></i> Delete</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@section('script_footer')

<script>
    $(function () {
      $("#dataTable").DataTable({
        "responsive": true,
      });
    });
</script>

@endsection