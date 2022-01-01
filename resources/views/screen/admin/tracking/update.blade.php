@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "Main Page" , "url" => "/" ],
    [ "name" => "Tracking" , "url" => route("tracking_index_page") ],
    [ "name" => "$model->id" , "url" => null ],
]

?>

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "Tracking - $model->name_en" , "breadcrumb" => $breadcrumb])

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
    <div class="col-md">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-folder-plus"></i> Edit tracking status information (แก้ไขข้อมูลสถานะการติดตาม)</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="POST" action="{{route("tracking_update_data")}}">

                    {{ csrf_field() }}

                    <input type="hidden" name="id" value="{{$model->id}}" />

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">ชื่อสถานะ (ภาษาไทย)</label>
                            <input type="text" class="form-control" value="{{$model->name_th}}" name="name_th" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Name Status Tag ( ENG )</label>
                            <input type="text" class="form-control" value="{{$model->name_en}}" name="name_en" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Role Given</label>
                            <select class="custom-select" name="role" required>
                                <option value={{$model->role}} selected>{{$model->role}}</option>
                                <option value={{$model->role == 'admin' ? 'user' : 'admin' }}>{{$model->role == 'admin' ? 'user' : 'admin' }}</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Update Data</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>



@endsection


@section('script_footer')



@endsection