@extends('layouts.app')

        @section('styles')

        @endsection

            @section('content')

                <!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Elements</h4><span
								class="text-muted mt-1 tx-13 ms-2 mb-0">/ Avatar</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						<div class="pe-1 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon me-2 btn-b"><i
									class="mdi mdi-filter-variant"></i></button>
						</div>
						<div class="pe-1 mb-xl-0">
							<button type="button" class="btn btn-danger btn-icon me-2"><i
									class="mdi mdi-star"></i></button>
						</div>
						<div class="pe-1 mb-xl-0">
							<button type="button" class="btn btn-warning  btn-icon me-2"><i
									class="mdi mdi-refresh"></i></button>
						</div>
						<div class="mb-xl-0">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-primary">14 Aug 2019</button>
								<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
									id="dropdownMenuDate" data-bs-toggle="dropdown" aria-haspopup="true"
									aria-expanded="false">
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
					<div class="col-lg-12 col-md-12">
						<div class="card custom-card" id="sizes">
							<div class="card-body">
								<div>
									<h6 class="card-title mb-1">Avatar Sizes</h6>
									<p class="text-muted card-sub-title">An avatar can have different sizes like larger
										and smaller avatar.</p>
								</div>
								<div class="text-wrap">
									<div class="example">
										<div class="demo-avatar-group">
											<div class="main-img-user avatar-xs">
												<img alt="avatar" class="rounded-circle"
													src="{{asset('assets/img/faces/2.jpg')}}">
											</div>
											<div class="main-img-user avatar-sm">
												<img alt="avatar" class="rounded-circle"
													src="{{asset('assets/img/faces/3.jpg')}}">
											</div>
											<div class="main-img-user">
												<img alt="avatar" class="rounded-circle"
													src="{{asset('assets/img/faces/4.jpg')}}">
											</div>
											<div class="main-img-user avatar-md">
												<img alt="avatar" class="rounded-circle"
													src="{{asset('assets/img/faces/5.jpg')}}">
											</div>
											<div class="main-img-user avatar-lg">
												<img alt="avatar" class="rounded-circle"
													src="{{asset('assets/img/faces/6.jpg')}}">
											</div>
											<div class="main-img-user avatar-xl d-none d-sm-block">
												<img alt="avatar" class="rounded-circle"
													src="{{asset('assets/img/faces/7.jpg')}}">
											</div>
											<div class="main-img-user avatar-xxl d-none d-sm-block">
												<img alt="avatar" class="rounded-circle"
													src="{{asset('assets/img/faces/8.jpg')}}">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-12 col-md-12">
						<div class="card custom-card" id="shapes">
							<div class="card-body">
								<div>
									<h6 class="card-title mb-1">Avatar Shapes</h6>
									<p class="text-muted card-sub-title">An avatar can have different shapes like square
										and round, radius avatars.</p>
								</div>
								<div class="text-wrap">
									<div class="example">
										<div class="demo-avatar-group">
											<div class="main-img-user avatar-md">
												<img alt="avatar" class="rounded-circle"
													src="{{asset('assets/img/faces/4.jpg')}}">
											</div>
											<div class="main-img-user avatar-md">
												<img alt="avatar" class="square" src="{{asset('assets/img/faces/5.jpg')}}">
											</div>
											<div class="main-img-user avatar-md">
												<img alt="avatar" class="radius" src="{{asset('assets/img/faces/6.jpg')}}">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="col-lg-12 col-md-12">
						<div class="card custom-card" id="initials">
							<div class="card-body">
								<div>
									<h6 class="card-title mb-1">Initials Avatars</h6>
									<p class="text-muted card-sub-title">An avatar can have a temporary use of user's
										initial name while their photos are not yet available.</p>
								</div>
								<div class="text-wrap">
									<div class="example">
										<div class="demo-avatar-group avatar-list">
											<div class="avatar avatar-xs bg-primary rounded-circle">
												A
											</div>
											<div class="avatar avatar-sm bg-secondary rounded-circle">
												U
											</div>
											<div class="avatar bg-info rounded-circle">
												C
											</div>
											<div class="avatar avatar-md bg-success rounded-circle">
												X
											</div>
											<div class="avatar avatar-lg d-none d-sm-flex bg-warning rounded-circle">
												E
											</div>
											<div class="avatar avatar-xl d-none d-sm-flex bg-danger rounded-circle">
												M
											</div>
											<div class="avatar avatar-xxl d-none d-sm-flex bg-pink rounded-circle">
												NB
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card custom-card" id="status">
							<div class="card-body">
								<div>
									<h6 class="card-title mb-1">Status Indicator</h6>
									<p class="text-muted card-sub-title">An avatar can have a status indicator to
										indicate users availability.</p>
								</div>
								<div class="text-wrap">
									<div class="example">
										<div class="demo-avatar-group">
											<div class="main-avatar avatar online">
												<img alt="avatar" class="rounded-circle avatar"
													src="{{asset('assets/img/faces/9.jpg')}}">
											</div>
											<div class="main-avatar avatar-md offline">
												eb
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-12 col-md-12">
						<div class="card custom-card">
							<div class="card-body">
								<div>
									<h6 class="card-title mb-1">Avatars with numbers</h6>
										<p class="text-muted card-sub-title">Avatars that show number badges.</p>
									</div>
									<div class="text-wrap">
										<div class="additional-avatars">
											<div class="demo-avatar-group">
												<div class="demo-avatar-group">
													<div class="main-img-user1 avatar-sm me-4">
														<img alt="avatar" class="rounded-circle" src="{{asset('assets/img/faces/2.jpg')}}">
														<span class="badge rounded-pill bg-primary number-badge">2</span>
													</div>
													<div class="main-img-user1 avatar-md me-4">
														<img alt="avatar" class="rounded-circle" src="{{asset('assets/img/faces/1.jpg')}}">
														<span class="badge rounded-pill bg-secondary number-badge">11</span>
													</div>
													<div class="main-img-user1 avatar-lg">
														<img alt="avatar" class="rounded-circle" src="{{asset('assets/img/faces/11.jpg')}}">
														<span class="badge rounded-pill bg-success number-badge">3</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
					</div>
					<div class="col-lg-12 col-md-12">
						<div class="card custom-card">
							<div class="card-body">
								<div>
									<h6 class="card-title mb-1">Avatars with icons</h6>
									<p class="text-muted card-sub-title">Avatars that show icon badges.</p>
								</div>
								<div class="text-wrap">
									<div class="additional-avatars">
										<div class="demo-avatar-group">
											<div class="demo-avatar-group">
												<div class="main-img-user3 avatar-sm me-4">
													<img alt="avatar" class="rounded-circle" src="{{asset('assets/img/faces/2.jpg')}}">
													<span class="badge rounded-pill bg-primary icon-badgeavatar"><i class="fe fe-plus"></i></span>
												</div>
												<div class="main-img-user3 avatar-md me-4">
													<img alt="avatar" class="rounded-circle" src="{{asset('assets/img/faces/1.jpg')}}">
													<span class="badge rounded-pill bg-secondary icon-badgeavatar"><i class="fe fe-edit"></i></span>
												</div>
												<div class="main-img-user3 avatar-lg">
													<img alt="avatar" class="rounded-circle" src="{{asset('assets/img/faces/11.jpg')}}">
													<span class="badge rounded-pill bg-success icon-badgeavatar"><i class="fe fe-delete"></i></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-md-12">
						<div class="card custom-card">
							<div class="card-body">
								<div>
									<h6 class="card-title mb-1">Stacked Avatars in Numbers</h6>
									<p class="text-muted card-sub-title">Group of avatars stacked together with number representation.</p>
								</div>
								<div class="text-wrap">
									<div class="avatar-list avatar-list-stacked">
										<span class="avatar1 brround"><img alt="" class="rounded-circle" src="{{asset('assets/img/faces/2.jpg')}}"></span>
										<span class="avatar1 brround"><img alt="" class="rounded-circle" src="{{asset('assets/img/faces/6.jpg')}}"></span>
										<span class="avatar1 brround"><img alt="" class="rounded-circle" src="{{asset('assets/img/faces/8.jpg')}}"></span>
										<span class="avatar1 brround"><img alt="" class="rounded-circle" src="{{asset('assets/img/faces/10.jpg')}}"></span>
										<span class="avatar1 brround"><img alt="" class="rounded-circle" src="{{asset('assets/img/faces/12.jpg')}}"></span>
										<span class="avatar1 brround">+8</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-md-12">
						<div class="card custom-card">
							<div class="card-body">
								<div>
									<h6 class="card-title mb-1">Stacked Avatars in Numbers</h6>
									<p class="text-muted card-sub-title">Avatars that show icon badges.</p>
								</div>
								<div class="text-wrap">
									<div class="avatar-list avatar-list-stacked">
										<span class="avatar1 brround"><img alt="" class="rounded-circle" src="{{asset('assets/img/faces/2.jpg')}}"></span>
										<span class="avatar1 brround"><img alt="" class="rounded-circle" src="{{asset('assets/img/faces/6.jpg')}}"></span>
										<span class="avatar1 brround"><img alt="" class="rounded-circle" src="{{asset('assets/img/faces/8.jpg')}}"></span>
										<span class="avatar1 brround"><img alt="" class="rounded-circle" src="{{asset('assets/img/faces/10.jpg')}}"></span>
										<span class="avatar1 brround"><img alt="" class="rounded-circle" src="{{asset('assets/img/faces/12.jpg')}}"></span>
										<span class="avatar1 brround"><i class="fe fe-plus"></i></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /row -->

            @endsection

        @section('scripts')

        <!-- Internal Select2 js-->
        <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

        <!-- Internal Prism js-->
	    <script src="{{asset('assets/plugins/prism/prism.js')}}"></script>
        
        @endsection

