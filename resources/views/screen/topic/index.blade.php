@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "Main Page" , "url" => route("topic_index_page") ],
    [ "name" => "Question To Me" , "url" => null ],
]

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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $index => $item )
                    <tr>

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