@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('properties.index') }}">Properties</a></li>
	<li class="is-active"><a>{{ $property->name }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $property->short_name }}
		@endslot
		@slot('subTitle')
			{{ $property->name }}
			@foreach ($property->owners as $user)
				<a href="{{ route('users.show', $user->id) }}">
					<span class="tag is-light">
						{{ $user->name }}
					</span>
				</a>
			@endforeach
		@endslot
	@endcomponent

	<section class="hero is-dark is-bold">
		<div class="hero-body">

			<nav class="level">
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Amount
						</p>
						<p class="title">
							
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
						Property
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('properties.show', $property->id) }}" class="{{ set_active(route('properties.show', $property->id)) }}">
								Dashboard
							</a>
							<a href="{{ route('properties.show', [$property->id, 'bank-account']) }}" class="{{ set_active(route('properties.show', [$property->id, 'bank-account'])) }}">
								Default Bank Account
							</a>
						</li>
					</ul>
				</aside>
			</div>
			<div class="column is-9">

				@yield('sub-content')

			</div>
		</div>

	@endcomponent

@endsection