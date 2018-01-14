@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Dashboard
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		<div class="row">
			<div class="col-12 col-lg-6">

				@include('dashboard.cards.tenancies')
				@include('dashboard.cards.tenancies-management')

			</div>
			<div class="col-sm-12 col-lg-6">

				@include('dashboard.cards.income')

			</div>
		</div>

	@endcomponent

@endsection