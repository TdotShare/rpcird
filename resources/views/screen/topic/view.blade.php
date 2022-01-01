@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "Main Page" , "url" => route("topic_index_page") ],
    [ "name" => "Question To Me" , "url" => route("topic_index_page") ],
    [ "name" => "$model->name" , "url" => null ],
];



$keywordItem = [
    "Research Advisory",
    "Publication Proofreading",
    "Paper Presentation"
];

$admin = ['jirayu.co'];

?>


@section('script_header')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "$model->name" , "breadcrumb" => $breadcrumb])

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
    <div class="col-md-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tag"></i> {{$model->name}}</h3>
            </div>
            <div class="card-body">
                @if ($model->file)
                    <p>Topic File : <a href={{ url("upload/$model->code/$model->file") }} target="_blank">{{$model->file}}</a></p>
                @endif
                <p>Key word : {{ $keywordItem[$model->keyword - 1] }} </p>
                <p>Author Name (ชื่อผู้ตั้งกระทู้) : {{ $model->create_by }} </p>
                <p>Author Email (email ผู้ตั้งกระทู้) : {{ $model->email }} </p>
                <p>Date Posted (วันที่ตั้งกระทู้) : {{ $model->create_at }}</p>
            </div>
        </div>
    </div>
</div>



<hr>

@foreach ($ansData as $index => $item)

<div class="row">
    <div class="col-md-12">
        <!-- Input addon -->
        <div class="card card-{{in_array(session('username') , $admin) ? 'info' : 'warning'}}">
            <div class="card-header">
                <h3 class="card-title"><i class="far fa-comments"></i> No. {{ $index++ }} | Detailed answers
                    (รายละเอียดคำตอบ) :</h3>
            </div>
            <div class="card-body">

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $item->content }}
                </div>

                @if ($item->file)
                <p>Attached File : <a href={{ url("upload/$model->code/$item->file") }} target="_blank">{{$model->file}}</a></p>
                @endif

                <p>Name of Respondent (ชื่อผู้ตอบ) : {{ $item->user_by}}</p>

                <p>Email (อีเมล์) : {{ $item->email}}</p>

                @if (session('role') == 'admin')
                    <a onclick="return confirm('delete confirm ?');" href={{route("answer_delete_data" , ["id" => $item->id])}}>
                        <button class="btn btn-danger"><i class="fas fa-trash-alt"></i> delete answers</button>
                    </a>
                @endif

            </div>

        </div>
    </div>
</div>

@endforeach

<hr>


<div class="row">
    <div class="col-md-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="far fa-comments"></i> Create Answer </h3>
            </div>
            <div class="card-body">

                <form method="POST" action="{{route("answer_create_data")}}" enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <input type="hidden" value="{{$model->id}}" name="topic_id">

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Content</label>
                        <textarea class="form-control" name="content" rows="3" required></textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Attached File</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" >
                    </div>

                    <div style="padding-bottom: 1%;"></div>

                    <button type="submit" class="btn btn-block btn-success">submit</button>

                </form>


            </div>
        </div>
    </div>
</div>


@endsection

@section('script_footer')

<script>

</script>


@endsection