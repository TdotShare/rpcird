@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "Main Page" , "url" => route("topic_index_page") ],
    [ "name" => "Question" , "url" => null ],
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

@component('common.breadcrumb' , [ "name" => "Question" , "breadcrumb" => $breadcrumb])

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
                        <th scope="col">Question name</th>
                        <th scope="col">Keyword</th>
                        <th scope="col">Answer Count</th>
                        <th scope="col">Date Create</th>
                        <th scope="col">Create By</th>
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
                        <td>{{$item->create_at}}</td>
                        <td>{{$item->create_by}}</td>
                        <td>

                            @if ($item->progress == 0)
                                Wait for the staff to read it
                            @else
                                  {{$ts_text}}
                            @endif


                        </td>
                        <td><a href={{route("topic_view_page" , ["id" => $item->id])}}><button class="btn btn-block btn-primary"><i class="fas fa-eye"></i> View</button></a></td>
                        <td><a href={{route("topic_track_page" , ["id" => $item->id])}}> <button class="btn btn-block btn-primary"><i class="fas fa-tags"></i> Tracking</button></a></td>
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