@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "Main Page" , "url" => route("topic_index_page") ],
    [ "name" => "Question To Me" , "url" => route("topic_index_page") ],
    [ "name" => "Create" , "url" => null ],
];


$keywordItem = [
    "Research Advisory",
    "Publication Proofreading",
    "Paper Presentation"
];


?>


@section('script_header')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "Create Question" , "breadcrumb" => $breadcrumb])

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


<div class="card">
    <div class="card-body">
        <form action={{route("topic_create_data")}} method="post" enctype="multipart/form-data">

            {{ csrf_field() }}


            <div class="form-row">
                <div class="form-group col-md">
                    <label >Question Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group col-md">
                    <label >Key Word</label>
                    <select class="custom-select" name="keyword" required >
                        <option value="" selected>Choose Key Word</option>
                        <option value="1" >Research Advisory</option>
                        <option value="2" >Publication Proofreading</option>
                        <option value="3" >Paper Presentation</option>
                      </select>
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-md">
                    <label for="exampleFormControlTextarea1">Content</label>
                    <textarea class="form-control" name="content"  rows="5" required></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Duration for Research ( Start )</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                        </div>
                        <input type="text" name="date_start" class="form-control" id="res_start" required>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Duration for Research ( End )</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                        </div>
                        <input type="text" name="date_end" class="form-control" id="res_end" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Attached File</label>
                    <input type="file" name="file" class="form-control"
                        accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.pdf">
                </div>
            </div>
        
            <button type="submit" class="btn btn-block btn-primary">Create</button>
        </form>
    </div>
</div>

@endsection

@section('script_footer')


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script>
    $(function () {

    $('#res_start').daterangepicker({
        drops: 'up',
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1990,
        locale: {
            format: 'YYYY-MM-DD'
        }
    })

    $('#res_end').daterangepicker({
        drops: 'up',
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1990,
        locale: {
            format: 'YYYY-MM-DD'
        }
    })


    

    });
</script>


@endsection