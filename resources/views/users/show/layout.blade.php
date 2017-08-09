@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">{{ $user->name }}</h1>

			<div class="control">
				<a href="{{ route('users.show', [$user->id, 'home-address']) }}" class="button is-warning">
					<span class="icon is-small">
						<i class="fa fa-edit"></i>
					</span>
					<span>
						Set Home Address
					</span>
				</a>

				<span class="tag is-medium {{ $user->home ? 'is-success' : '' }}">
					{{ $user->home ? $user->home->name : 'Not Set' }}
				</span>
			</div>

			<hr />

			<div class="columns">
				<div class="column is-4">

					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								User Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="has-text-grey">Title</td>
								<td class="has-text-right">{{ $user->title }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">First Name</td>
								<td class="has-text-right">{{ $user->first_name }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Last Name</td>
								<td class="has-text-right">{{ $user->last_name }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Company</td>
								<td class="has-text-right">{{ $user->company_name }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Mobile Phone</td>
								<td class="has-text-right">{{ $user->phone_number }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Other Phone Number</td>
								<td class="has-text-right">{{ $user->phone_number_other }}</td>
							</tr>
						</table>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('users.show', [$user->id, 'edit-details']) }}">Edit Details</a>
							<a class="card-footer-item" href="{{ route('users.show', [$user->id, 'change-password']) }}">Edit Password</a>
						</footer>
					</div>

					<div class="card">
						<header class="card-header">
							<p class="card-header-title">
								System Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="has-text-grey">Branch</td>
								<td class="has-text-right">{{ $user->branch ? $user->branch->name : '' }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Created By</td>
								<td class="has-text-right">{{ $user->owner ? $user->owner->name : '' }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Created On</td>
								<td class="has-text-right">{{ date_formatted($user->created_at) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Last Updated On</td>
								<td class="has-text-right">{{ date_formatted($user->updated_at) }}</td>
							</tr>
						</table>
					</div>

				</div>
				<div class="column is-8">

					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">E-Mail History</p>
						</header>
						<div class="card-content">
							<b>Current E-Mail:</b> {{ $user->email }}
						</div>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('users.show', [$user->id, 'update-email']) }}">Edit E-Mail</a>
							<a class="card-footer-item" href="{{ route('users.show', [$user->id, 'send-email']) }}">Send E-Mail Message</a>
						</footer>
					</div>

				</div>
			</div>
		</div>
	</section>

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $user->name }}
		@endslot
		@slot('subTitle')
			{{ $user->home_inline }}
		@endslot
	@endcomponent

	<section class="hero is-dark is-bold">
		<div class="hero-body">

			<nav class="level">
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							E-Mail
						</p>
						<p class="title">
							{{ $user->email }}
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Mobile
						</p>
						<p class="title">
							{{ $user->phone_number }}
						</p>
					</div>
				</div>
			</nav>

		</div>
	</section>

	@component('partials.sections.section')

		<div class="columns is-flex is-column-mobile">
			<div class="column is-3">
				<aside class="menu">
					<p class="menu-label">
						User
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('users.show', $user->id) }}" class="{{ set_active(route('users.show', $user->id)) }}">
								<span class="icon is-small">
									<i class="fa fa-user"></i>
								</span>
								Account Details
							</a>
							<a href="{{ route('users.show', [$user->id, 'update-email']) }}" class="{{ set_active(route('users.show', [$user->id, 'update-email'])) }}">
								<span class="icon is-small">
									<i class="fa fa-envelope"></i>
								</span>
								Update E-Mail
							</a>
							<a href="{{ route('users.show', [$user->id, 'change-password']) }}" class="{{ set_active(route('users.show', [$user->id, 'change-password'])) }}">
								<span class="icon is-small">
									<i class="fa fa-lock"></i>
								</span>
								Change Password
							</a>
							<a href="{{ route('users.show', [$user->id, 'home-address']) }}" class="{{ set_active(route('users.show', [$user->id, 'home-address'])) }}">
								<span class="icon is-small">
									<i class="fa fa-home"></i>
								</span>
								Home Address
							</a>
							<a href="{{ route('users.show', [$user->id, 'notifications']) }}" class="{{ set_active(route('users.show', [$user->id, 'notifications'])) }}">
								<span class="icon is-small">
									<i class="fa fa-bell"></i>
								</span>
								Notifications
							</a>		
						</li>
					</ul>
					<p class="menu-label">
						Actions
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('users.show', [$user->id, 'send-email']) }}">
								<span class="icon is-small">
									<i class="fa fa-envelope-open"></i>
								</span>
								Send E-Mail
							</a>
						</li>
					</ul>
					<p class="menu-label">
						Tenancies
					</p>
					<p class="menu-label">
						Payments
					</p>
				</aside>
			</div>
			<div class="column is-9">

				@yield('sub-content')

			</div>
		</div>

	@endcomponent

@endsection