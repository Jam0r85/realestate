@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('statements.show', $statement->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">Statement #{{ $statement->id }}</h1>
			<h2 class="subtitle">Send the statement to it's owners.</h2>

			<hr />

			@if ($statement->sent_at)
				<div class="notification is-success">
					This statement has already been sent to it's owners on <b>{{ date_formatted($statement->sent_at) }}</b>
				</div>
			@endif

			@if ($statement->sendByEmail())
				<div class="notification">
					This statement is sent by E-Mail
					@if (!$statement->hasUserEmails())
						<span class="has-text-danger">
							No e-mails were found for the owners of this statement.
						</span>
					@else
						to 
						@php echo(implode(', ', $statement->getUserEmails())) @endphp
					@endif
				</div>
			@endif

			<form role="form" method="POST" action="{{ route('statements.send') }}">
				{{ csrf_field() }}
				<input type="hidden" name="statements" value="{{ $statement->id }}" />

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-envelope-open"></i>
					</span>
					<span>
						Send Statement
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection