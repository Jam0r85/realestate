@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			SMS History
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div id="messages">
			@include('sms.partials.messages-list')
		</div>

		@include('partials.pagination', ['collection' => $messages])

	@endcomponent

@endsection

@push('footer_scripts')

@endpush