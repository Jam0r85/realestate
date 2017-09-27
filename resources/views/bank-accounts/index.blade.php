@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					Bank Accounts
					<a href="{{ route('bank-accounts.create') }}" class="btn btn-primary">
						<i class="fa fa-plus"></i> New Account
					</a>
				</h1>
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

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('bank-accounts.partials.table')

		</div>
	</section>

@endsection