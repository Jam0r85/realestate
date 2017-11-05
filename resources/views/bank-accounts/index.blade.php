@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('bank-accounts.create') }}" class="btn btn-primary float-right">
				<i class="fa fa-plus"></i> New Account
			</a>

			@component('partials.header')
				Bank Accounts
			@endcomponent

		</div>

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

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('bank-accounts.partials.bank-accounts-table')

	@endcomponent

@endsection