@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			@component('partials.header')
				Reports
			@endcomponent

		</div>

		@include('partials.errors-block')

		<div class="row">
			<div class="col-sm-12 col-lg-6">

				@include('reports.cards.hmrc-landlord-income')
				@include('reports.cards.landlord-tax-report')

			</div>
			<div class="col-sm-12 col-lg-6">

			</div>
		</div>

	@endcomponent

@endsection