@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "Main Page" , "url" => route("topic_index_page") ],
    [ "name" => "Account" , "url" => null ],
]

?>


@section('script_header')



@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "Account" , "breadcrumb" => $breadcrumb])

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


<div class="card shadow p-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">email</th>
                        <th scope="col">fullname</th>
                        <th scope="col">department</th>
                        <th scope="col">faculty</th>
                        <th scope="col">campus</th>
                        <th scope="col">list question</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ([] as $index => $item )
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