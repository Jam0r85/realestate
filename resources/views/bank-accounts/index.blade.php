@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('bank-accounts.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-plus"></i> New Account
		</a>

		@component('partials.header')
			{{ isset($title) ? $title : 'Bank Accounts List' }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.index-search', ['route' => 'bank-accounts.search', 'session' => 'bank_account_search_term'])

		<ul class="nav nav-pills">
			{!! Filter::archivePill() !!}
		</ul>

		@include('bank-accounts.partials.bank-accounts-table')

	@endcomponent

@endsection