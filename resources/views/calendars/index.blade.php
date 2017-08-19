@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">Calendars</h1>

			<a href="{{ route('calendars.create') }}" class="button is-primary is-outlined">
				<span class="icon is-small">
					<i class="fa fa-plus"></i>
				</span>
				<span>
					New Calendar
				</span>
			</a>

			<hr />

			@include('calendars.partials.table', ['calendars' => $calendars])

		</div>
	</section>

@endsection