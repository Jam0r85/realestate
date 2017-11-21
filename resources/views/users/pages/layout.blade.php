@php
	$sections = ['Details','Properties','Tenancies','Invoices','Bank Accounts'];
@endphp

@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@include('users.partials.user-dropdown-menu')
		</div>

		@component('partials.header')
			{{ $user->present()->fullName }}
		@endcomponent
		
	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col-12 col-lg-2">

				@include('users.layout.vertical-menu')

			</div>
			<div class="col-12 col-lg-10">

				<div class="tab-content" id="v-pills-tabContent">
					@foreach ($sections as $section)
						@include('users.sections.' . str_slug($section))
					@endforeach
				</div>

			</div>
		</div>

	@endcomponent

	@include('users.modals.user-send-sms-modal')

@endsection