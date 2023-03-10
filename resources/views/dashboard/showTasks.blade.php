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
            <button type="button" class="btn btn-info btn-icon me-2 btn-b"><i
                    class="mdi mdi-filter-variant"></i></button>
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
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                    id="dropdownMenuDate" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuDate"
                    x-placement="bottom-end">
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
    @if(Auth::user()->role->title === 'Admin')
    <div class="card mg-b-20" id="tabs-style2">
        <div class="card-body">
            <div class="main-content-label mg-b-5">
                ??????????
            </div>

            <div class="text-wrap">
                <div class="example">
                    <div class="panel panel-primary tabs-style-2">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab4" class="nav-link active" data-bs-toggle="tab">?????????? ????
                                            ??????????????</a>
                                    </li>
                                    <li><a href="#tab5" class="nav-link" data-bs-toggle="tab">
                                            ?????????? ???? ??????????????????</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab4">
                                    <form action="{{route('dashboard.searchStation')}}" method="GET">
                                        <div class="row d-flex justify-content-start mb-3">
                                            <input list="ssnames" type="search" class="col-3 mx-sm-3 mb-2 form-control"
                                                name="station" placeholder="search in stations">

                                            <datalist id="ssnames">
                                                @foreach ($stations as $station)
                                                <option value="{{ $station->SSNAME }}">
                                                    @endforeach
                                            </datalist>
                                            <button type="submit"
                                                class="col-1 btn btn-secondary bg-secondary mb-2">????????</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="tab5">
                                    <form action="{{route('dashboard.engineerTasks')}}" method="GET">
                                        <div class="row d-flex justify-content-start mb-3">
                                            <input list="engineers" type="search"
                                                class="col-3 mx-sm-3 mb-2 form-control" name="engineer"
                                                placeholder="search in engineers">
                                            <datalist id="engineers">
                                                @foreach ($engineers as $engineer)
                                                <option value="{{ $engineer->user->name }}">
                                                    @endforeach
                                            </datalist>
                                            <button type="submit"
                                                class="col-1 btn btn-secondary bg-secondary mb-2">????????</button>
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
                <a class="nav-link {{ Route::is('dashboard.showTasks') && request()->status == 'all' ? 'active' : '' }}"
                    href="{{route('dashboard.showTasks',['status'=>'all'])}}">???? ??????????????</a>
                <a class="nav-link {{ Route::is('dashboard.showTasks') && request()->status == 'pending' ? 'active' : '' }}"
                    href="{{route('dashboard.showTasks',['status'=>'pending'])}}">?????????????? ??????????
                    ??????????????</a>
                <a class="nav-link {{ Route::is('dashboard.showTasks') && request()->status == 'completed' ? 'active' : '' }}"
                    href="{{route('dashboard.showTasks',['status'=>'completed'])}}">?????????????? ??????????????</a>
                <a class="nav-link {{ Route::is('dashboard.showTasks') && request()->status == 'mutual-tasks' ? 'active' : '' }}"
                    href="{{route('dashboard.showTasks',['status'=>'mutual-tasks'])}}">?????????????? ????????????????</a>
            </nav>
        </div>
    </div>
    @endif
    @foreach($tasks as $task)
    <div class="col-12 col-sm-12 col-lg-6 col-xl-4 my-2">
        <div class="card {{$task->status =='pending'  ? 'card-danger' : 'card-success'}} h-100 ">

            <div class="card-body  ">
                <ul class="list-group   text-center">

                    <li class="list-group-item {{ ($task->status == 'pending') ? 'bg-danger': 'bg-success' }}">Task #
                        {{$task->id}}
                    </li>
                    <li class="list-group-item ">{{$task->created_at}} - {{$task->department->name}}</li>
                    <li class="list-group-item "> <strong>Station<br>
                        </strong>
                        <span style="font-size:22px; font-wieght:bold;">{{$task->station->SSNAME}}</span>
                    </li>
                    <li class="list-group-item"><strong>Main Alarm
                            <br></strong>@isset($task->main_alarm->name){{$task->main_alarm->name}}@endisset</li>
                    <li class="list-group-item"><strong>Equip <br></strong>{{$task->equip_number}}</li>

                    <li class="list-group-item"><strong>Nature of fault<br></strong>{{$task->problem}}
                    </li>
                    @isset($task->eng_id)
                    <a class="" href="{{route('dashboard.engineerProfile',['eng_id'=>$task->eng_id])}}">
                        <li class="list-group-item bg-light text-dark"><strong>Engineer <br></strong>
                            {{$task->engineer->name}}
                        </li>
                    </a>
                    @endisset
                </ul>
            </div>
            <div class="card-footer">
                {{-- <button class="btn {{$task->status =='pending'  ? 'btn-danger' : 'btn-success'}}">More
                    information</button> --}}
                @if(Auth::user()->role->title == 'Admin')
                <div class="row">

                    @if($task->status !== 'completed')
                    <div class="col">
                        <a class="btn btn-dark" href="{{route('dashboard.editTask', ['id' => $task->id])}}">??????????</a>
                    </div>
                    <div class="col">
                        <form method="post" action="{{route('task.destroy', ['id' => $task->id])}}"
                            id="delete-form-{{ $task->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="deleteRecord({{ $task->id }})"
                                class="btn btn-outline-danger">?????? ????????????</button>

                        </form>
                    </div>
                    @endif

                </div>
                @endif
                @if($task->status === 'completed')
                <div class="col">
                    <a href="{{route('dashboard.reportPage',['id'=>$task->id])}}" type="button"
                        class="btn btn-outline-success  button-icon "><i class="si si-notebook px-2"
                            data-bs-toggle="tooltip" title="" data-bs-original-title="si-notebook"
                            aria-label="si-notebook"></i>Report</a>
                </div>
                @endif

            </div>
        </div>
    </div>

    @endforeach
    {{ $tasks->links() }}


</div>
<!-- row closed -->

@endsection

@section('scripts')
<!-- Internal Select2 js-->
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
            title: '???? ?????? ?????????? ???? ???????? ????????????',
            text: '???????? ?????????? ?????????? ??????????????',
            icon: '??????????',
            showCancelButton: true,
            confirmButtonText: '?????? ?? ???????? ????????????',
            cancelButtonText: '??????????',
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