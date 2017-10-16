@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<a href="{{ route('statements.show', $statement->id) }}" class="btn btn-secondary float-right">
				Return
			</a>
			<h1>Statement #{{ $statement->id }}</h1>
			<h3>{{ $statement->sent_at ? 'Resend' : 'Send' }} the statement to it's owners.</h3>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@if ($statement->sent_at)
			<div class="alert alert-success lead">
				This statement has already been sent to it's recipients on <b>{{ date_formatted($statement->sent_at) }}</b>
			</div>
		@endif

		<div class="card mb-3 border-primary">
			<div class="card-header bg-primary text-white">
				{{ $statement->sent_at ? 'Resend' : 'Sent' }} Statement
			</div>
			<div class="card-body">

				<p class="card-text">
					You can {{ $statement->sent_at ? 'resend' : 'Send' }} this statement to the following recipients by e-mail.
				</p>

				<ul class="mb-5">
					@foreach ($statement->users as $user)
						<li>
							{{ $user->email }} ({{ $user->name }})
						</li>
					@endforeach
				</ul>

				<form method="POST" action="{{ route('statements.resend', $statement->id) }}">
					{{ csrf_field() }}

					<input type="hidden" name="statement_id" value="{{ $statement->id }}" />

					<div class="form-group">
						<button type="submit" class="btn btn-primary">
							<i class="fa fa-send fa-fw"></i> Resend Statement
						</button>
					</div>

				</form>

				<em>Note that recipients without an e-mail address will not receive anything.</em>

			</div>
		</div>

	@endcomponent

@endsection