@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "Main Page" , "url" => route("topic_index_page") ],
    [ "name" => "Dashboard" , "url" => null ],
]

?>


@section('script_header')




@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "Dashboard" , "breadcrumb" => $breadcrumb])

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
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ App\Model\Topic::count() }} <sup style="font-size: 20px">Question</sup></h3>

        <p>question all</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ App\Model\Topic::where('progress' , '=' , '0')->count() }} <sup style="font-size: 20px">Unanswered</sup>
        </h3>
        <p>Unanswered question all</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
    </div>
  </div>
</div>

<hr>

<div class="row">
  @foreach ($trackdata as $item)

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ App\Model\Topic::where('progress' , '=' , $item->id)->count() }} <sup
            style="font-size: 20px">Question</sup></h3>

        <p>{{$item->name_en}}</p>
      </div>
      <div class="icon">
        <i class="fas fa-question"></i>
      </div>
    </div>
  </div>

  @endforeach

</div>


<div class="alert alert-secondary" role="alert">
  <h4 class="alert-heading">Update System RPCIRD - 12/04/2022 (NEW)</h4>
  <hr>
    <ul>
      <li>The graph menu works. <a href="{{route('graph_index_page')}}">click</a> !! (เรียกข้อมูลออกมาเป็นกราฟ)</li>
    </ul>
</div>

<div class="alert alert-info" role="alert">
  <h4 class="alert-heading">Update System RPCIRD - 14/03/2022</h4>
  <hr>
    <ul>
      <li>Fix Upload File category Answer (แก้ไขการอัปโหลดไฟล์ที่แสดงผลไม่ตรง)</li>
    </ul>
</div>


@endsection


@section('script_footer')



@endsection