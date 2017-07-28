@extends('statements.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			{{ isset($statement->sent_at) ? 'Re-Send' : 'Send' }} Statement to Owner
		@endcomponent

		@if ($statement->sent_at)
			@component('partials.notifications.primary')
				Statement was sent {{ date_formatted($statement->sent_at) }}
			@endcomponent
		@endif

		<form role="form" method="POST" action="{{ route('statements.send', $statement->id) }}">
			{{ csrf_field() }}

			@component('partials.forms.buttons.primary')
				Send Statement
			@endcomponent

		</form>

	@endcomponent

@endsection