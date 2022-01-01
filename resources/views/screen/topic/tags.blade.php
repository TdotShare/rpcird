@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "Main Page" , "url" =>  route("topic_index_page") ],
    [ "name" => "Question To Me" , "url" =>  route("topic_index_page") ],
    [ "name" => "Tracking $model->id" , "url" => null ],
]

?>

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "Tags - ($model->id) $model->name" , "breadcrumb" => $breadcrumb])

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

@php

$ts_text = "";

if($model->progress != 0){
    $ts_model = \App\Model\Tracking::find($model->progress);
    $ts_text = $ts_model->name_en;
    }else{
    $ts_text = "Wait for the staff to read it";
}

@endphp

<form>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputEmail4">Tracking Status (Present) | สถานะการติดตามปัจจุบัน </label>
            <input type="text" class="form-control" value="{{$ts_text}}" readonly>
        </div>
    </div>
</form>

<form method="POST" action="{{route("topic_tracking_data")}}">

    {{ csrf_field() }}

    <input type="hidden" value="{{$model->id}}" name="id">


    <div class="form-group">
        <label>Tracking Status</label>
        <select class="form-control" name="tracking_status" required>
            <option selected value="">Select Tracking Status ...</option>
            @if (session('role') == 'admin')
                @foreach (\App\Model\Tracking::all() as $item)
                <option value="{{$item->id}}">{{$item->name_en . " ( $item->name_th ) " }}</option>
                @endforeach
            @else
                @foreach (\App\Model\Tracking::where("role" , "=" , 'user')->get() as $item)
                <option value="{{$item->id}}">{{$item->name_en . " ( $item->name_th ) " }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <button class="btn btn-success">Save Data</button>
</form>




@endsection


@section('script_footer')



@endsection