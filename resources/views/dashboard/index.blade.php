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
            <div class="btn-group dropdown">
                <button type="button" class="btn btn-primary">لوحة التحكم حسب التحكم</button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuDate" x-placement="bottom-end">
                    <a class="dropdown-item" href="javascript:void(0);">تحكم الجهراء</a>
                    <a class="dropdown-item" href="javascript:void(0);">تحكم الشعيبة</a>
                    <a class="dropdown-item" href="javascript:void(0);">تحكم الجابرية</a>
                    <a class="dropdown-item" href="javascript:void(0);">تحكم المدينة</a>
                    <a class="dropdown-item" href="javascript:void(0);">تحكم الوطني</a>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row ">
    <div class="col-xl-3 col-lg-6 col-md-6 ">
        <div class="card  bg-primary-gradient">
            <div class="card-body">
                <div class="counter-status d-flex md-mb-0">
                    <div class="counter-icon">
                        <i class="icon icon-people"></i>
                    </div>
                    <div class="ms-auto">
                        <h5 class="tx-18 tx-white-8 mb-3 ">عدد أعطال الشهر</h5>
                        <h2 class="counter mb-0 text-white">{{$sectionTasksCount}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card  bg-danger-gradient">
            <div class="card-body">
                <div class="counter-status d-flex md-mb-0">
                    <div class="counter-icon text-warning">
                        <i class="icon icon-rocket"></i>
                    </div>
                    <div class="ms-auto">
                        <h5 class="tx-18 tx-white-8 mb-3">عدد الأعطال الغير منجزة</h5>
                        <h2 class="counter mb-0 text-white">{{$pendingTasksCount}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card  bg-success-gradient">
            <div class="card-body">
                <div class="counter-status d-flex md-mb-0">
                    <div class="counter-icon text-primary">
                        <i class="icon icon-docs"></i>
                    </div>
                    <div class="ms-auto">
                        <h5 class="tx-18 tx-white-8 mb-3">عدد الأعطال المنجزة</h5>
                        <h2 class="counter mb-0 text-white">{{$completedTasksCount}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card  bg-warning-gradient">
            <div class="card-body">
                <div class="counter-status d-flex md-mb-0">
                    <div class="counter-icon text-success">
                        <i class="icon icon-emotsmile"></i>
                    </div>
                    <div class="ms-auto">
                        <h5 class="tx-18 tx-white-8 mb-3">ارشيف التقارير</h5>
                        <h2 class="counter mb-0 text-white">{{$completedTasksCount}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- row -->
<div class="row">
    <div class="col-12 col-sm-12 col-lg-6 col-xl-3">
        @foreach($pendingTasks as $task)
        <div class="card card-primary">
            <div class="card-header pb-0">
                <h3 class="card-title mb-0 pb-0">Tasks</h3>
            </div>
            <div class="card-body  ">
                <ul class="list-group   text-center">
                    <li class="list-group-item bg-info">Task # 1 </li>
                    <li class="list-group-item ">{{$task->main_task->created_at}}</li>
                    <li class="list-group-item "> <strong>Station<br> <span class="badge bg-danger me-1 my-2">Pending</span></strong> {{$task->main_task->station->SSNAME}} </li>
                    <li class="list-group-item"><strong>Main Alarm <br></strong>{{$task->main_task->main_alarm->name}}</li>
                    <li class="list-group-item"><strong>Nature of fault<br></strong>{{$task->main_task->problem}}
                    </li>
                    <li class="list-group-item"><strong>Engineer <br></strong> {{$task->engineer->user->name}}</li>
                </ul>
            </div>
            <div class="card-footer">
                <button class="btn btn-secondary">More information</button>

            </div>
        </div>
        @endforeach


    </div>
    <div class="col-xl-9 col-md-12 col-lg-6">
        <div class="card border border-dark">
            <div class="card-header pb-1">
                <h1 class="card-title mb-2 text-center"> تقارير شهر يناير</h1>

            </div>
            @foreach($completedTasks as $task)
            <div class=" card-body pt-2 mt-1 text-center ">

                <ul class="timeline-1 mb-0 ">
                    <li class="mt-0 mb-0 border border-secondary pb-2">
                        <p class="p-3 mb-2 bg-dark text-white text-center">Engineer :
                            {{$task->engineer->user->name}}
                        </p>
                        <p class="  bg-white text-dark text-center  "><ins>Station :
                                {{$task->main_task->station->SSNAME}}</ins></p>
                        <span class="badge bg-success me-1 my-2">Completed</span>
                        <p class="text-right text-muted"> {{$task->created_at}}</p>

                        <p class=" bg-white text-secondary font-weight-bold text-center">Nature of fault :
                            {{$task->main_task->problem}}
                        </p>
                        <p class="p-3 mb-2 bg-light text-dark text-center">Action Take :
                            {{$task->action_take}}
                        </p>
                        <a class="btn btn-info mt-2 text-center" href="www.google.com">Report</a>
                        <a class="btn btn-outline-dark mt-2 text-center" href="">Details</a>
                    </li>
                </ul>

            </div>
            @endforeach
            <hr class="my-4 bg-info">
            <nav aria-label="Page navigation pagination-sm   pagination-lg justify-content-center ">
                <ul class="pagination">
                    <li class="page-item">

                    </li>

                </ul>
            </nav>
        </div>



    </div>
</div>
<!-- row closed -->

@endsection

@section('scripts')
<script src="{{asset('assets/js/index.js')}}"></script>
<!--Internal Counters -->
<script src="{{asset('assets/plugins/counters/waypoints.min.js')}}"></script>
<script src="{{asset('assets/plugins/counters/counterup.min.js')}}"></script>

<!--Internal Time Counter -->
<script src="{{asset('assets/plugins/counters/jquery.missofis-countdown.js')}}"></script>
<script src="{{asset('assets/plugins/counters/counter.js')}}"></script>


@endsection