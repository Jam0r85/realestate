@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('statements.show', $statement->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>Statement #{{ $statement->id }}</h1>
				<h3>Send the statement to it's owners.</h3>
			</div>

			@if ($statement->sent_at)
				<div class="alert alert-success">
					This statement has already been sent to it's owners on <b>{{ date_formatted($statement->sent_at) }}</b>
				</div>
			@endif

			<form role="form" method="POST" action="{{ route('statements.send') }}">
				{{ csrf_field() }}
				<input type="hidden" name="statements" value="{{ $statement->id }}" />

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-envelope-open"></i> Send Statement
				</button>

			</form>

		</div>
	</section>

@endsection