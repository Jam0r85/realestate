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

		<ul class="nav nav-pills">
			<li class="nav-item">
				{!! Menu::showLink('Details', 'users.show', $user->id, 'index') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Properties', 'users.show', $user->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Tenancies', 'users.show', $user->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Invoices', 'users.show', $user->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Expenses', 'users.show', $user->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Bank Accounts', 'users.show', $user->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('E-Mail History', 'users.show', $user->id, 'emails-history') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('SMS History', 'users.show', $user->id) !!}
			</li>
		</ul>

		@include('users.show.' . $show)

	@endcomponent

	@include('users.modals.user-send-sms-modal')
	@include('users.modals.send-email-modal')

@endsection