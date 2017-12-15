@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userSendSmsMessage">
				<i class="fa fa-comment"></i> Send SMS
			</button>

			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userSendEmailModal">
				<i class="fa fa-envelope"></i> Send E-Mail
			</button>

			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="userOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-cogs"></i> Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userOptionsDropdown">
					<a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">
						Edit User
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

	@component('partials.bootstrap.section-with-container')

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