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
					The statement was sent to it's owners on <b>{{ date_formatted($statement->sent_at) }}</b>
				</div>
			@endif

			<div class="alert @if (!$statement->getUserEmails()) alert-danger @else alert-info @endif">
				@if (!$statement->getUserEmails())
					The users assigned to this statement do not have valid e-mail addresses.
				@else
					Statement Recipients:
					<ul>
						@foreach ($statement->users as $user)
							<li>
								{{ $user->name }} ({{ $user->email }})
							</li>
						@endforeach
					</ul>
				@endif
			</div>

			<div class="alert alert-info">
				Statements are usual sent to the owners of this property by 
				@if ($statement->sendByPost())
					Post
				@endif
				@if ($statement->sendByEmail())
					E-Mail
				@endif
			</div>

			<form role="form" method="POST" action="{{ route('statements.resend', $statement->id) }}">
				{{ csrf_field() }}

				<input type="hidden" name="statement_id" value="{{ $statement->id }}" />

				<button type="submit" class="btn btn-primary" @if (!$statement->getUserEmails()) disabled @endif>
					<i class="fa fa-envelope-open"></i> Send Statement By E-Mail
				</button>

			</form>

		</div>
	</section>

@endsection