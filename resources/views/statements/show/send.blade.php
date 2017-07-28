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

		@else

		@endif

	@endcomponent

@endsection