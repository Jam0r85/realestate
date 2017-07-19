@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('settings.index') }}">Settings</a></li>
	<li><a href="{{ route('settings.invoice-groups') }}">Invoice Groups</a></li>
	<li><a href="{{ route('invoice-groups.show', $invoice_group->id) }}">{{ $invoice_group->name }}</a></li>
	<li class="is-active"><a>Edit</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $invoice_group->name }}
		@endslot
	@endcomponent

	<form role="form" method="POST" action="{{ route('invoice-groups.update', $invoice_group->id) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}

		@component('partials.sections.section')
			@slot('saveButton')
				Save Changes
			@endslot

			@include('partials.errors-block')

			@include('invoice-groups.partials.form')

		@endcomponent

	</form>

@endsection