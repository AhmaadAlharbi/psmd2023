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
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                    id="dropdownMenuDate" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuDate"
                    x-placement="bottom-end">
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
    {{-- @if(session('success'))
    <div class="alert alert-success">
        <div class="card bd-0 mg-b-20 bg-success">
            <div class="card-body text-white">
                <div class="main-error-wrapper">
                    <i class="si si-check mg-b-20 tx-50"></i>
                    <h4 class="mg-b-0"> {{ session('success') }}</h4>
                </div>
            </div>
        </div>
    </div>
    @endif --}}

    <div class="col-xl-3 col-lg-6 col-md-6 ">

        <a href="{{route('dashboard.engineersList')}}">
            <div class="card  bg-primary-gradient">
                <div class="card-body">
                    <div class="counter-status d-flex md-mb-0">
                        <div class="counter-icon">
                            <i class="icon icon-people"></i>
                        </div>
                        <div class="ms-auto">
                            <h5 class="tx-18 tx-white-8 mb-3 ">عدد المهندسين </h5>
                            <h2 class="counter mb-0 text-white">{{$engineersCount}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <a href="{{route('dashboard.showTasks',['status'=>'pending'])}}">
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
        </a>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <a href="{{route('dashboard.showTasks',['status'=>'completed'])}}">
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
        </a>
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
        <div class="card card-danger">

            <div class="card-body  ">
                <ul class="list-group   text-center">
                    <li class="list-group-item bg-danger-gradient text-white"> Task # {{$task->id}} </li>
                    <li class="list-group-item ">{{$task->created_at}}</li>
                    <li class="list-group-item "> <strong>Station<br> </strong> {{$task->station->SSNAME}}
                    </li>
                    <li class="list-group-item"><strong>Main Alarm <br></strong>{{$task->main_alarm->name}}</li>
                    <li class="list-group-item"><strong>Nature of fault<br></strong>{{$task->problem}}
                    </li>
                    <a class="" href="{{route('dashboard.engineerProfile',['eng_id'=>$task->eng_id])}}">
                        <li class="list-group-item text-dark bg-light"><strong>Engineer
                                <br></strong>{{$task->engineer->name}}
                        </li>
                    </a>
                </ul>
            </div>
            <div class="card-footer">

                <button data-bs-toggle="dropdown" class="btn btn-danger btn-block"></i>العمليات <i
                        class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                <div class="dropdown-menu">
                    <a href="{{route('dashboard.editTask',['id'=>$task->id])}}" class="dropdown-item">تعديل</a>
                    <a href="/engineer-task-page/{{$task->id}}" class="btn btn-outline-secondary dropdown-item">Engineer
                        report</a>
                </div><!-- dropdown-menu -->

            </div>
        </div>

        @endforeach


    </div>


    <div class="col-xl-5 col-md-12 col-lg-6">
        <div class="card border border-dark">

            @foreach($completedTasks as $task)

            <div class="card card-info">

                <div class="card-body  ">
                    <ul class="list-group   text-center">
                        <li class="list-group-item bg-info-gradient text-white">Task # {{$task->id}} </li>

                        <li class="list-group-item " style="font-size:18px; font-wieght:bold;">
                            <ins>Station :
                                {{$task->main_task->station->SSNAME}} </ins><br>
                            <hr>
                            <span style="font-size:16px">{{
                                \Carbon\Carbon::parse($task->created_at)->format('Y-m-d') }} | {{
                                \Carbon\Carbon::parse($task->created_at)->format('H:i') }}</span>
                        </li>
                        <!-- <li class="list-group-item"><strong>Date <br></strong>{{ \Carbon\Carbon::parse($task->created_at)->format('Y-m-d') }} | {{ \Carbon\Carbon::parse($task->created_at)->format('H:i') }}
                        </li> -->
                        <!-- <li class="list-group-item bg-light"><strong>Main Alarm <br></strong>{{$task->main_task->main_alarm->name}}</li> -->
                        <li class="list-group-item " style="font-size:16px;"><strong>Nature of fault<br></strong>
                            {{$task->main_task->problem}}
                        </li>
                        <li class="list-group-item bg-light" style="font-size:16px;"><strong>Action Take<br></strong>
                            {{$task->action_take}}
                        </li>
                        <a class="" href="{{route('dashboard.engineerProfile',['eng_id'=>$task->eng_id])}}">
                            <li class="list-group-item text-dark bg-light"><strong>Engineer <br></strong>
                                {{$task->engineer->user->name}}
                            </li>
                        </a>

                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{route('dashboard.reportPage',['id'=>$task->main_task->id])}}" type="button"
                        class="btn btn-info  button-icon "><i class="si si-notebook px-2" data-bs-toggle="tooltip"
                            title="" data-bs-original-title="si-notebook" aria-label="si-notebook"></i>Report</a>
                    {{-- <a href="/engineer-task-page/{{$task->id}}" class="btn btn-outline-secondary">Engineer
                        report</a> --}}

                </div>
            </div>
            @endforeach
        </div>

    </div>
    <div class="col-xl-4">
        <div class="card card-dark">

            <div class="card-body  ">
                <div class="chartjs-wrapper-demo">
                    <canvas id="chartBar4"></canvas>
                </div>
                </ul>
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

    <!--Internal  Chart.bundle js -->
    <script src="{{asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>

    <!-- Internal Chartjs js -->
    <script src="{{asset('assets/js/chart.chartjs.js')}}"></script>
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var ctx = document.getElementById('chartBar4').getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        datasets: [{
            label: 'Total Tasks',
            data: [{{ implode(',', $taskCounts) }}],
            backgroundColor: 'rgba(54, 162, 235)',
            borderColor: 'rgb(54, 162, 235)',
            borderWidth: 1
        },
        {
            label: 'Pending Tasks',
            data: [{{ implode(',', $pendingTaskCounts) }}],
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 1
        },
        {
            label: 'Completed Tasks',
            data: [{{ implode(',', $completedTaskCounts) }}],
            backgroundColor:  'rgb(50, 205, 50)',
            borderColor: 'rgb(34, 139, 34)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
    </script>
    <script>
        $(document).ready(function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}'
                });
            @endif
        });
    </script>
    @endsection