@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('statements.show', $statement->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				Statement #{{ $statement->id }}
			@endcomponent

			@component('partials.sub-header')
				Statement options and actions
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3">

			@component('partials.card-header')
				{{ $statement->sent_at ? 'Re-Send' : 'Send' }} Statement
			@endcomponent

			<div class="card-body">

				<p class="card-text">
					Send this statement to the landlords of this property. You can force this statement to be sent by e-mail where a PDF version of the statement, invoice and any expenses will be attached.
				</p>

				<form method="POST" action="{{ route('statements.send', $statement->id) }}">
					{{ csrf_field() }}

					@if ($statement->sent_at)

						@component('partials.alerts.primary')
							This statement has been sent previously and will be re-sent by email with the statement, invoice and expenses attached.
						@endcomponent

					@endif

					@component('partials.save-button')
						Send Statement
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection