@extends('layouts.app')

@section('styles')

@endsection

@section('content')

<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Empty</span>
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

    </div>
</div>
<!-- breadcrumb -->

<!-- row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card border border-primary">
            <div class="card-body">
                <div>
                    <div class="row m-5">
                        <div class="col-lg-6">
                            <img src="{{URL::asset('assets/img/server.svg')}}" alt="">

                        </div>
                        <div class="col-lg-6">
                            @livewire('add-task')
                        </div>

                    </div>
                </div>




            </div>

        </div>
    </div>
</div>
<!-- row closed -->

@endsection

@section('scripts')



@endsection