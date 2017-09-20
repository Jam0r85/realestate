@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					Calendars List
					<a href="{{ route('calendars.create') }}" class="btn btn-primary" title="New Calendar">
						<i class="fa fa-user-plus"></i> New Calendar
					</a>
				</h1>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('calendars.partials.table')

		</div>
	</section>

@endsection