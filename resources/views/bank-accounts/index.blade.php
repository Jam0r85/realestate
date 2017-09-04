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
			<div class="page-search">
				<form role="form" method="POST" action="{{ route('bank-accounts.search') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<div class="input-group">
							{{-- Clear Search Button --}}
							@if (session('bank_accounts_search_term'))
								<span class="input-group-btn">
									<button type="submit" class="btn btn-danger" name="clear_search" value="true">
										<i class="fa fa-trash"></i> Clear
									</button>
								</span>
							@endif
							<input type="text" name="search_term" class="form-control" placeholder="Search for..." value="{{ session('bank_accounts_search_term') }}" />
							<span class="input-group-btn">
								<button type="submit" class="btn btn-secondary">
									<i class="fa fa-search"></i> Search
								</button>
							</span>
						</div>
					</div>
				</form>
			</div>

			@include('bank-accounts.partials.table')

		</div>
	</section>

@endsection