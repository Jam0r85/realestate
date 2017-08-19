@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">New Calendar</h1>

			<hr />

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('calendars.store') }}">
				{{ csrf_field() }}

				@include('calendars.partials.form')

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Create Calendar
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection