@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "Main Page" , "url" => route("topic_index_page") ],
    [ "name" => "Graph" , "url" => null ],
]

?>


@section('script_header')



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


<div class="alert alert-success" role="alert">
    In development , available soon
</div>


@endsection


@section('script_footer')

@endsection