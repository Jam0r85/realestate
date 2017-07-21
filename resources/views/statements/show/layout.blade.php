@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('statements.index') }}">Statements</a></li>
	<li class="is-active"><a>{{ $statement->name }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $statement->name }}
		@endslot
		@slot('subTitle')
			{{ $statement->property->name }}
			@foreach ($statement->users as $user)
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
							Started
						</p>
						<p class="title">
							
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Amount
						</p>
						<p class="title">
							{{ currency($statement->amount) }}
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Invoices Total
						</p>
						<p class="title">
							
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Expenses Total
						</p>
						<p class="title">
							
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Landlord Balance
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
						Statement
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('statements.show', $statement->id) }}" class="{{ set_active(route('statements.show', $statement->id)) }}">
								Dashboard
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