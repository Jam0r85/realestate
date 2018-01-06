@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="mb-2 text-right">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userSendSmsMessage">
				@icon('sms') Send SMS
			</button>

			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userSendEmailModal">
				@icon('email') Send E-Mail
			</button>

			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="userOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					@icon('options') Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userOptionsDropdown">
					<a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">
						@icon('edit') Edit User
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			{{ $user->present()->fullName }}
		@endcomponent

		@component('partials.sub-header')
			{{ $user->present()->location('full') }}
		@endcomponent
		
	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		@if ($unpaidExpenses = count($user->unpaidExpenses))
			@component('partials.alerts.warning')
				This user has <b>{{ $unpaidExpenses }} unpaid</b> expenses.
			@endcomponent
		@endif

		<ul class="nav nav-pills">
			<li class="nav-item">
				<a class="nav-link @if (!Request::segment('3')) active @endif" href="{{ route('users.show', $user->id) }}">
					Details
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('users.show', [$user->id, 'properties']) }}">
					Properties
					<span class="badge badge-dark">
						{{ count($user->properties) }}
					</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('users.show', [$user->id, 'tenancies']) }}">
					Tenancies
					<span class="badge badge-dark">
						{{ count($user->tenancies) }}
					</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (Request::segment('3') == 'invoices') active @endif" href="{{ route('users.show', [$user->id, 'invoices']) }}">
					Invoices
					<span class="badge badge-dark">
						{{ count($user->invoices) }}
					</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('users.show', [$user->id, 'expenses']) }}">
					Expenses
					<span class="badge badge-dark">
						{{ count($user->expenses) }}
					</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('users.show', [$user->id, 'bank-accounts']) }}">
					Bank Accounts
					<span class="badge badge-dark">
						{{ count($user->bankAccounts) }}
					</span>
				</a>
			</li>
			<li class="nav-item">
				{!! Menu::showLink('E-Mail History', 'users.show', $user->id, 'emails-history') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('SMS History', 'users.show', $user->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Notifications', 'users.show', $user->id) !!}
			</li>
		</ul>

		@include('users.show.' . $show)

	@endcomponent

	@include('users.modals.user-send-sms-modal')
	@include('users.modals.send-email-modal')

@endsection