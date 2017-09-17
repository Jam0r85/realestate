@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('gas-safe.show', $reminder->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $reminder->property->short_name }} Gas Safe Reminder</h1>
				<h3>Delete the reminder</h3>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('gas-safe.destroy', $reminder->id) }}">
				{{ csrf_field() }}
				{{ method_field('DELETE') }}

				<button type="submit" class="btn btn-danger">
					<i class="fa fa-trash"></i> Delete Reminder
				</button>

			</form>

		</div>
	</section>

@endsection