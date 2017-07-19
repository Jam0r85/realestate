@extends('settings.template')

@section('breadcrumbs')
	<li><a href="{{ route('settings.index') }}">Settings</a></li>
	<li class="is-active"><a>Invoice Groups</a></li>
@endsection

@section('sub-content')

	@component('partials.sections.section-no-container')
		@slot('title')
			Invoice Groups
		@endslot
		@slot('subTitle')
			Current active invoice groups for all branches.
		@endslot

		@include('invoice-groups.partials.table', ['invoice_groups' => $invoice_groups])

	@endcomponent

	@component('partials.sections.section-no-container')
		@slot('title')
			Archived Invoice Groups
		@endslot
		@slot('subTitle')
			Old invoice groups which have now been archived and are no longer used.
		@endslot

		@include('invoice-groups.partials.table', ['invoice_groups' => $archived_invoice_groups])

	@endcomponent

	<form role="form" method="POST" action="{{ route('invoice-groups.store') }}">
		{{ csrf_field() }}

		@component('partials.sections.section-no-container')
			@slot('title')
				New Invoice Group
			@endslot
			@slot('subTitle')
				Create a new invoice group for the company.
			@endslot

			@include('partials.errors-block')

			@include('invoice-groups.partials.form')

			<button type="submit" class="button is-primary is-outlined">
				Create Group
			</button>

		@endcomponent

	</form>

@endsection