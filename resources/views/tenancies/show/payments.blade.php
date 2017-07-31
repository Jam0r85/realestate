@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Payments
		@endcomponent

		@include('payments.partials.table', ['payments' => $tenancy->rent_payments])

	@endcomponent

@endsection