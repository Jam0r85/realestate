@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('bank-accounts.index') }}">Bank Accounts List</a></li>
	<li class="is-active"><a>New Bank Account</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			New Bank Account
		@endslot
	@endcomponent

	@component('partials.sections.section')

		<form role="form" method="POST" action="{{ route('bank-accounts.store') }}">
			{{ csrf_field() }}

			@include('partials.errors-block')

			@include('bank-accounts.partials.form')

			@component('partials.forms.buttons.primary')
				Create Bank Account
			@endcomponent

		</form>

	@endcomponent

@endsection