@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<div class="float-right">
				@include('payments.partials.dropdown-menus')
			</div>

			@component('partials.header')
				Payment {{ $payment->id }}
			@endcomponent
			
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col col-5">

				@include('payments.partials.system-info-card')

			</div>
			<div class="col col-7">

				@include('payments.partials.payment-info-card')

			</div>
		</div>

	@endcomponent

@endsection