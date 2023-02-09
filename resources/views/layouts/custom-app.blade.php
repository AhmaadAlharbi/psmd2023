<!doctype html>
<html lang="en"> <!-- This "app.blade.php" master page is used for all the pages content present in "views/livewire" except "custom" and "switcher" pages -->
	<head>

        <meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Valex - Laravel Bootstrap 5 Admin & Dashboard Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="laravel admin template, bootstrap admin template, admin dashboard template, admin dashboard, admin template, admin, bootstrap 5, laravel admin, laravel admin dashboard template, laravel ui template, laravel admin panel, admin panel, laravel admin dashboard, laravel template, admin ui dashboard">

		<!-- Title -->
		<title> Valex -  Premium dashboard ui bootstrap rwd admin html5 template </title>
       
		@include('layouts.components.custom-styles')

    </head>

    @yield('body')

        <!-- Page -->
		<div class="page">
        
            @yield('content')

        </div>
		<!-- End Page -->

        @include('layouts.components.custom-scripts')

    </body>

</html>
