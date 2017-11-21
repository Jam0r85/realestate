@php
	$sections = ['Details','Properties','Tenancies','Invoices','Bank Accounts'];
	$history = ['EMail History','SMS History'];
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

				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

					@foreach ($sections as $section)
						<a class="nav-link {{ $loop->first ? 'active' : '' }}" id="v-pills-{{ str_slug($section) }}-tab" data-toggle="pill" href="#v-pills-{{ str_slug($section) }}" role="tab">
							{{ $section }}
						</a>
					@endforeach

					<div class="dropdown-divider"></div>

					@foreach ($history as $item)
						<a class="nav-link" id="v-pills-{{ str_slug($item) }}-tab" data-toggle="pill" href="#v-pills-{{ str_slug($item) }}" role="tab">
							{{ $item }}
						</a>
					@endforeach

				</div>

			</div>
			<div class="col-12 col-lg-10">

				<div class="tab-content" id="v-pills-tabContent">

					@foreach ($sections as $section)
						@include('users.sections.' . str_slug($section))
					@endforeach

					@foreach ($history as $item)
						@include('users.sections.' . str_slug($item))
					@endforeach

				</div>

			</div>
		</div>

	@endcomponent

	@include('users.modals.user-send-sms-modal')

@endsection