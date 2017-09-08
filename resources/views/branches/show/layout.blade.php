@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<div class="float-right">
					@include('branches.partials.dropdown-menus')
				</div>
				<h1>{{ $branch->name }}</h1>
			</div>

			<div class="row">
				<div class="col col-5">

					@include('branches.partials.staff-card')
					@include('branches.partials.system-info-card')

				</div>
				<div class="col col-7">

					@include('branches.partials.branch-info-card')

				</div>
			</div>

			<hr />

		</div>
	</section>

@endsection