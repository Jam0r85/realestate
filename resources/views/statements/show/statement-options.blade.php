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
					Send this statement, invoice and any expenses by e-mail to the landlords of this property.
				</p>

				<form method="POST" action="{{ route('statements.send', $statement->id) }}">
					{{ csrf_field() }}
					<input type="hidden" name="by_email" value="true" />

					@component('partials.save-button')
						Send Statement
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection