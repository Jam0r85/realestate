@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('bank-accounts.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-plus"></i> New Account
		</a>

		@component('partials.header')
			Bank Accounts
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		{{-- Bank Accounts Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('bank-accounts.search') }}
			@endslot
			@if (session('bank_accounts_search_term'))
				@slot('search_term')
					{{ session('bank_accounts_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Bank Accounts Search --}}

		<ul class="nav nav-pills">
			<li class="nav-item">
				<a class="nav-link @if (!request('archived')) active @endif" href="{{ Filter::link('bank-accounts.index', ['archived' => null]) }}">
					Active
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (request('archived') == 'true') active @endif" href="{{ Filter::link('bank-accounts.index', ['archived' => 'true']) }}">
					Archived
				</a>
			</li>
		</ul>

		@include('bank-accounts.partials.bank-accounts-table')

	@endcomponent

@endsection