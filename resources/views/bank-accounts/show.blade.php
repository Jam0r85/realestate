@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="bankAccountOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="bankAccountOptionsDropdown">
					<a class="dropdown-item" href="{{ route('bank-accounts.edit', $account->id) }}">
						<i class="fa fa-edit"></i> Edit Bank Account
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			{{ $account->account_name }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@if ($account->deleted_at)
			@component('partials.alerts.secondary')
				This bank account was deleted {{ date_formatted($account->deleted_at) }}
			@endcomponent
		@endif

		<ul class="nav nav-pills">
			<li class="nav-item">
				{!! Menu::showLink('Details', 'bank-accounts.show', $account->id, 'index') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Payments', 'bank-accounts.show', $account->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Properties', 'bank-accounts.show', $account->id) !!}
			</li>
		</ul>

		@include('bank-accounts.show.' . $show)

	@endcomponent

@endsection