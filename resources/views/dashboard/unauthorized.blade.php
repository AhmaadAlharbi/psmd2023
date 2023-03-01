@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center mt-5">
            <img src="https://res.cloudinary.com/razeshzone/image/upload/v1588316204/house-key_yrqvxv.svg"
                class="img-key" alt="">
            <p class="lead">لايمكنك المتابعة لأنك لا تمتلك الصلاحية لكتابة التقرير لهذه المحطة</p>

            <p class="lead">You are not authorized to access this page.</p>
            @if(Auth::user()->role->title === 'Admin')
            <a href="{{route('dashboard.index')}}" class="btn btn-primary">Home Page</a>

            @else
            <a href="{{route('dashboard.userIndex')}}" class="btn btn-primary">Home Page</a>
            @endif

        </div>
    </div>
</div>
@endsection