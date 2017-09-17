@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<div class="float-right">
					@include('gas-safe.partials.dropdown-menus')
				</div>
				<h1>{{ $reminder->property->short_name }} Gas Safe Reminder</h1>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

		</div>
	</section>

@endsection