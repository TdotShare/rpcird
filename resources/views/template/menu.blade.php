<?php 

//  ["name" => "จองห้องประชุม", "menu" => null , "url" => route("reserveroom_index_page") , "icon" => "fas fa-door-closed" , "path" => "/reserveroom"] ,

$menuUser = [
    ["name" => "Question To Me", "menu" => null , "url" => route("topic_index_page") , "icon" => "fas fa-question-circle" , "path" => "/topic"] ,
    ["name" => "Relations", "menu" => null , "url" => route("relations_index_page") , "icon" => "fas fa-bullhorn" , "path" => "/relations"] ,
];

$menuAdmin = [
    ["name" => "Dashboard", "menu" => null , "url" => route("dashboard_index_page") , "icon" => "fas fa-th" , "path" => "/admin/dashboard"] ,
    ["name" => "Question", "menu" => null , "url" => route("question_index_page") , "icon" => "fas fa-question-circle" , "path" => "/admin/question"] ,
    ["name" => "Account", "menu" => null , "url" => route("account_index_page") , "icon" => "fas fa-users" , "path" => "/admin/account"] ,
    ["name" => "Tracking Text", "menu" => null , "url" => route("tracking_index_page") , "icon" => "fas fa-tags" , "path" => "/admin/tracking"] ,
    ["name" => "Graph", "menu" => null , "url" => route("graph_index_page") , "icon" => "fas fa-chart-pie" , "path" => "/admin/graph"] ,
];
?>

<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src={{URL::asset("assets/image/mock/profile.png")}} class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ session("fullname") }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

            {{-- <li class="nav-item">
                <a href={{route("dashboard_index_page")}}
                    class="{{ Request::path() == "dashboard" ? "nav-link active" : "nav-link"  }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        ภาพรวมระบบ
                    </p>
                </a>
            </li> --}}

            @foreach ($menuUser as $item)

            @if ($item["menu"] == null)

            {{-- <li class="nav-item">
                <a href={{$item["url"]}}
            class="{{ Request::path() == $item["path"] ? "nav-link active" : "nav-link"  }}">
            <i class="nav-icon {{$item["icon"]}}"></i>
            <p>
                {{$item["name"]}}
            </p>
            </a>
            </li> --}}

            <li class="nav-item">
                <a href={{$item["url"]}}
                    class="{{ Request::route()->getPrefix() == $item["path"] ? "nav-link active" : "nav-link"  }}">
                    <i class="nav-icon {{$item["icon"]}}"></i>
                    <p>
                        {{$item["name"]}}
                    </p>
                </a>
            </li>

            @else

            {{-- <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon {{$item["icon"]}}"></i>
            <p>
                {{$item["name"]}}
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            @foreach ($item["menu"] as $row)
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href={{$row["url"]}} class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{$row["name"]}}</p>
                    </a>
                </li>
            </ul>
            @endforeach

            </li> --}}

            <li
                class="{{ Request::route()->getPrefix() == $item["path"] ? "nav-item has-treeview  menu-open" : "nav-item has-treeview"  }}">
                <a href="#"
                    class="{{ Request::route()->getPrefix() == $item["path"] ? "nav-link active" : "nav-link"  }}">
                    <i class="nav-icon {{$item["icon"]}}"></i>
                    <p>
                        {{$item["name"]}}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                @foreach ($item["menu"] as $row)
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href={{$row["url"]}}
                            class="{{Request::path() == $row["path"] ? "nav-link active" : "nav-link" }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{$row["name"]}}</p>
                        </a>
                    </li>
                </ul>
                @endforeach

            </li>

            @endif

            @endforeach


            @if (session("role") == "admin")

            <li class="nav-header">Admin</li>

            @foreach ($menuAdmin as $item)

            @if ($item["menu"] == null)

            <li class="nav-item">
                <a href={{$item["url"]}}
                    class="{{ Request::route()->getPrefix() == $item["path"] ? "nav-link active" : "nav-link"  }}">
                    <i class="nav-icon {{$item["icon"]}}"></i>
                    <p>
                        {{$item["name"]}}
                    </p>
                </a>
            </li>

            @else

            <li
                class="{{ Request::route()->getPrefix() == $item["path"] ? "nav-item has-treeview  menu-open" : "nav-item has-treeview"  }}">
                <a href="#"
                    class="{{ Request::route()->getPrefix() == $item["path"] ? "nav-link active" : "nav-link"  }}">
                    <i class="nav-icon {{$item["icon"]}}"></i>
                    <p>
                        {{$item["name"]}}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                @foreach ($item["menu"] as $row)
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href={{$row["url"]}}
                            class="{{Request::path() == $row["path"] ? "nav-link active" : "nav-link" }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{$row["name"]}}</p>
                        </a>
                    </li>
                </ul>
                @endforeach

            </li>

            @endif

            @endforeach

            @endif



        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>