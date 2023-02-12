@extends('layouts.app')

@section('styles')

@endsection

@section('content')

<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 ms-2 mb-0">/
                Empty</span>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pe-1 mb-xl-0">
            <button type="button" class="btn btn-info btn-icon me-2 btn-b"><i class="mdi mdi-filter-variant"></i></button>
        </div>
        <div class="pe-1 mb-xl-0">
            <button type="button" class="btn btn-danger btn-icon me-2"><i class="mdi mdi-star"></i></button>
        </div>
        <div class="pe-1 mb-xl-0">
            <button type="button" class="btn btn-warning  btn-icon me-2"><i class="mdi mdi-refresh"></i></button>
        </div>
        <div class="mb-xl-0">
            <div class="btn-group dropdown">
                <button type="button" class="btn btn-primary">14 Aug 2019</button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuDate" x-placement="bottom-end">
                    <a class="dropdown-item" href="javascript:void(0);">2015</a>
                    <a class="dropdown-item" href="javascript:void(0);">2016</a>
                    <a class="dropdown-item" href="javascript:void(0);">2017</a>
                    <a class="dropdown-item" href="javascript:void(0);">2018</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- row -->
<div class="row">
    <div class="card mg-b-20" id="tabs-style2">
        <div class="card-body">
            <div class="main-content-label mg-b-5">
                البحث
            </div>

            <div class="text-wrap">
                <div class="example">
                    <div class="panel panel-primary tabs-style-2">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab4" class="nav-link active" data-bs-toggle="tab">البحث في
                                            المحطات</a>
                                    </li>
                                    <li><a href="#tab5" class="nav-link" data-bs-toggle="tab">
                                            البحث في المهندسين</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab4">
                                    <form action="{{route('dashboard.searchStation')}}" method="GET">
                                        <div class="row d-flex justify-content-start mb-3">
                                            <input list="ssnames" type="search" class="col-3 mx-sm-3 mb-2 form-control" name="station" placeholder="search in stations">

                                            <datalist id="ssnames">
                                                @foreach ($stations as $station)
                                                <option value="{{ $station->SSNAME }}">
                                                    @endforeach
                                            </datalist>
                                            <button type="submit" class="col-1 btn btn-secondary bg-secondary mb-2">ابحث</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="tab5">
                                    <form action="{{route('dashboard.engineerTasks')}}" method="GET">
                                        <div class="row d-flex justify-content-start mb-3">
                                            <input list="engineers" type="search" class="col-3 mx-sm-3 mb-2 form-control" name="engineer" placeholder="search in engineers">
                                            <datalist id="engineers">
                                                @foreach ($engineers as $engineer)
                                                <option value="{{ $engineer->user->name }}">
                                                    @endforeach
                                            </datalist>
                                            <button type="submit" class="col-1 btn btn-secondary bg-secondary mb-2">ابحث</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="example">
        <div class="p-3 bg-light text-dark border">
            <nav class="nav main-nav flex-column flex-md-row">
                <a class="nav-link active" href="{{route('dashboard.showTasks',['status'=>'all'])}}">كل المهمات</a>
                <a class="nav-link" href="{{route('dashboard.showTasks',['status'=>'pending'])}}">المهمات الغير
                    المنجزة</a>
                <a class="nav-link" href="{{route('dashboard.showTasks',['status'=>'completed'])}}">المهمات المنجزة</a>
            </nav>
        </div>
    </div>
    @foreach($tasks as $task)
    <div class="col-12 col-sm-12 col-lg-6 col-xl-3">
        <div class="card card-primary">
            <div class="card-header pb-0">
                <h3 class="card-title mb-0 pb-0">Tasks</h3>
            </div>
            <div class="card-body  ">
                <ul class="list-group   text-center">

                    <li class="list-group-item {{ ($task->status == 'pending') ? 'bg-danger': 'bg-success' }}">Task # 1
                    </li>
                    <li class="list-group-item ">{{$task->created_at}}</li>
                    <li class="list-group-item "> <strong>Station<br> <span class="badge {{ ($task->status == 'pending') ? 'bg-danger': 'bg-success' }} me-1 my-2">{{$task->status}}</span></strong>
                        {{$task->station->SSNAME}}
                    </li>
                    <li class="list-group-item"><strong>Main Alarm <br></strong>{{$task->main_alarm->name}}</li>
                    <li class="list-group-item"><strong>Nature of fault<br></strong>{{$task->problem}}
                    </li>
                    <li class="list-group-item"><strong>Engineer <br></strong>{{$task->engineer->name}}</li>
                </ul>
            </div>
            <div class="card-footer">
                <button class="btn btn-secondary">More information</button>
                @if($task->status === 'completed')
                <a href="{{route('dashboard.reportPage',['id'=>$task->id])}}" type="button" class="btn btn-info  button-icon "><i class="si si-notebook px-2" data-bs-toggle="tooltip" title="" data-bs-original-title="si-notebook" aria-label="si-notebook"></i>Report</a>
                @endif

            </div>
        </div>
    </div>

    @endforeach


</div>
<!-- row closed -->

@endsection

@section('scripts')



@endsection