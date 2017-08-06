@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('users.index') }}">Users</a></li>
	<li class="is-active"><a>{{ $user->name }}</a></li>
@endsection

@section('content')

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