@extends('layouts.app')

@section('styles')

@endsection

@section('content')

<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">

    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">لوحة التحكم</h4><span class="text-muted mt-1 tx-13 ms-2 mb-0">/
                {{Auth::user()->department->name}}</span>

        </div>

    </div>
    <div class="btn-group dropdown">
        <button type="button" class="btn btn-primary">لوحة التحكم حسب التحكم</button>
        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuDate" x-placement="bottom-end">
            <a class="dropdown-item" href="{{route('dashboard.indexControl',['control'=>'JAHRA CONTROL CENTER'])}}">تحكم
                الجهراء</a>
            <a class="dropdown-item"
                href="{{route('dashboard.indexControl',['control'=>'SHUAIBA CONTROL CENTER'])}}">تحكم
                الشعيبة</a>
            <a class="dropdown-item"
                href="{{route('dashboard.indexControl',['control'=>'JABRIYA CONTROL CENTER'])}}">تحكم
                الجابرية</a>
            <a class="dropdown-item" href="{{route('dashboard.indexControl',['control'=>'TOWN CONTROL CENTER'])}}">تحكم
                المدينة</a>
            <a class="dropdown-item"
                href="{{route('dashboard.indexControl',['control'=>'NATIONAL CONTROL CENTER'])}}">تحكم
                الوطني</a>
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
        <a href="{{route('dashboard.archive')}}">

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
        </a>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <a href="{{route('dashboard.showTasks',['status'=>'mutual-tasks'])}}">

            <div class="card  bg-purple-gradient">
                <div class="card-body">
                    <div class="counter-status d-flex md-mb-0">
                        <div class="counter-icon text-success">
                            <i class="icon icon-emotsmile"></i>
                        </div>
                        <div class="ms-auto">
                            <h5 class="tx-18 tx-white-8 mb-3">مهمات مشتركة مع الاقسام</h5>
                            <h2 class="counter mb-0 text-white">{{$mutualTasks}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<!-- breadcrumb -->

<!-- row -->
<div class="row">
    @foreach($pendingTasks as $task)

    <div class="col-12 col-sm-12 col-lg-6 col-xl-3  overflow-x-auto">
        <div class="card card-danger h-100">
            <div class="card-body">
                <ul class="list-group text-center">
                    <li class="list-group-item bg-danger-gradient text-white">Task #{{$task->id}}</li>
                    <li class="list-group-item">{{$task->created_at}}</li>
                    <li class="list-group-item"><strong>Station</strong><br>{{$task->station->SSNAME}}</li>
                    <li class="list-group-item"><strong>Main
                            Alarm</strong><br>@isset($task->main_alarm->name){{$task->main_alarm->name}}@endisset</li>
                    <li class="list-group-item"><strong>Equip</strong><br>{{$task->equip_number}}</li>
                    <li class="list-group-item"><strong>Nature of fault</strong><br>{{$task->problem}}</li>
                    @isset($task->engineer->name)

                    <a href="{{route('dashboard.engineerProfile', ['eng_id' => $task->eng_id])}}">
                        <li class="list-group-item text-dark bg-light">
                            <strong>Engineer</strong><br>@isset($task->engineer->name){{$task->engineer->name}}@endisset
                        </li>
                    </a>
                    @endisset
                </ul>
            </div>
            <div class="card-footer">
                <div class="dropdown">
                    <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">العمليات </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('dashboard.editTask', ['id' => $task->id])}}">تعديل</a>
                        <form method="post" action="{{route('task.destroy', ['id' => $task->id])}}"
                            id="delete-form-{{ $task->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="deleteRecord({{ $task->id }})"
                                class="btn btn-outline-danger">Delete
                                <i class="fas fa-trash " style="color:red"></i>

                            </button>

                        </form>
                        @isset($task->engineer->name)
                        <a class="dropdown-item btn btn-outline-secondary"
                            href="/engineer-task-page/{{$task->id}}">Engineer report</a>
                        @endisset
                    </div>
                </div>
            </div>
        </div>





    </div>
    @endforeach
    <div class="d-flex flex-wrap justify-content-center mt-5">
        <nav class="pagination">
            {{ $pendingTasks->links() }}
        </nav>
    </div>
    <div class="col-xl-12 col-md-12 col-lg-6">
        <div class="card border ">
            @foreach($completedTasks as $task)
            <div class="card card-info">
                <div class="card-body  ">
                    <ul class="list-group   text-center">
                        <li class="list-group-item bg-success py-3 text-white">Task # {{$task->main_task->id}} </li>
                        <li class="list-group-item " style="font-size:18px; font-wieght:bold;">
                            Station :
                            {{$task->main_task->station->SSNAME}}<br>
                            <hr>
                            <span style="font-size:16px">{{
                                \Carbon\Carbon::parse($task->created_at)->format('Y-m-d') }} | {{
                                \Carbon\Carbon::parse($task->created_at)->format('H:i') }}</span>
                        </li>
                        <li class="list-group-item " style="font-size:16px;"><strong>Nature of fault<br></strong>
                            {{$task->main_task->problem}}
                        </li>
                        <li class="list-group-item"><strong>Equip <br></strong>{{$task->main_task->equip_number}}</li>

                        <li class="list-group-item bg-light" style="font-size:16px;"><strong>Action Take<br></strong>
                            {{$task->action_take}}
                        </li>
                        <a class="" href="{{route('dashboard.engineerProfile',['eng_id'=>$task->eng_id])}}">
                            <li class="list-group-item text-dark bg-light"><strong>Engineer <br></strong>
                                {{$task->engineer->name}}
                            </li>
                        </a>

                    </ul>
                </div>
                <div class="card-footer">
                    {{-- <a href="{{route('dashboard.reportPage',['id'=>$task->main_task->id])}}" type="button"
                        class="btn btn-info  button-icon "><i class="si si-notebook px-2" data-bs-toggle="tooltip"
                            title="" data-bs-original-title="si-notebook" aria-label="si-notebook"></i>Report</a> --}}
                    <a href="{{route('dashboard.reportPage',['id'=>$task->main_task->id])}}"
                        class="btn btn-secondary"><i class="si si-notebook px-2" data-bs-toggle="tooltip" title=""
                            data-bs-original-title="si-notebook" aria-label="si-notebook"></i>Report</a></button>
                    {{-- <form method="post" action="{{route('sectionTasks.destroy', ['id' => $task->id])}}"
                        id="delete-form-{{ $task->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deleteRecord({{ $task->id }})"
                            class="btn btn-danger">Delete</button>

                    </form> --}}
                    {{-- <a href="/engineer-task-page/{{$task->id}}" class="btn btn-outline-secondary">Engineer
                        report</a> --}}

                </div>
            </div>
            @endforeach
            @empty($completedTasks)
            d
            @endempty
        </div>
        {{ $completedTasks->links() }}


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

<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
//delete tasks
<script>
    function deleteRecord(id) {
      Swal.fire({
        title: 'هل أنت متأكد من خيار الحذف؟',
        text: 'يرجى تحديد خيارك بالأسفل',
        icon: 'تحذير',
        showCancelButton: true,
        confirmButtonText: 'نعم ، احذف المهمة',
        cancelButtonText: 'إلغاء',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-form-' + id).submit();
        }
      });
    }
</script>

@endsection