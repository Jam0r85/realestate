@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			SMS Messages History
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		<div id="messages">
			@include('sms.partials.messages-list')
		</div>

		@include('partials.pagination', ['collection' => $messages])

	@endcomponent

@endsection

@push('footer_scripts')

@endpush