@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "Main Page" , "url" => route("topic_index_page") ],
    [ "name" => "Tracking Status" , "url" => null ],
]

?>


@section('script_header')



@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "Tracking Status" , "breadcrumb" => $breadcrumb])

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
                <h3 class="card-title"><i class="fas fa-folder-plus"></i>  Add tracking status information (เพิ่มข้อมูลสถานะการติดตาม)</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route("tracking_create_data")}}">

                    {{ csrf_field() }}

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">ชื่อสถานะ (ภาษาไทย)</label>
                            <input type="text" class="form-control" name="name_th" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Name Status Tag ( ENG )</label>
                            <input type="text" class="form-control" name="name_en" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Role Given</label>
                            <select class="custom-select" name="role" required>
                                <option value="" selected>choose please ...</option>
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Save Data</button>

                </form>
            </div>
        </div>
    </div>
</div>


<div class="card shadow p-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">name_th</th>
                        <th scope="col">name_en</th>
                        <th scope="col">role</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $index => $item)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $item->name_th }}</td>
                        <td>{{ $item->name_en }}</td>
                        <td>{{ $item->role }}</td>
                        <td><a href="{{route("tracking_view_page" , ["id" => $item->id  ])}}"><button
                                    class="btn btn-block btn-success"><i class="fas fa-edit"></i> Edit</button></a></td>
                        <td><a href="{{route("tracking_delete_data" , ["id" => $item->id  ])}}"><button
                                    class="btn btn-block btn-danger"><i class="fas fa-trash"></i> Delete</button></a></td>
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