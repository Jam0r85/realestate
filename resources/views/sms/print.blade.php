@extends('layouts.print')

@section('content')

	@component('partials.section-with-container')

		<h2 class="mb-5">
			SMS Message
			<small class="text-muted">{{ \Carbon\Carbon::now()->toDayDateTimeString() }}</small>
		</h2>

		@each('sms.partials.message', $messages, 'message')

	@endcomponent

@endsection