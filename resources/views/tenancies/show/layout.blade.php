@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('tenancies.index') }}">Tenancies</a></li>
	<li><a href="{{ route('properties.show', $tenancy->property->id) }}">{{ $tenancy->property->short_name }}</a></li>
	<li class="is-active"><a>{{ $tenancy->name }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $tenancy->name }}
			<span class="tag is-light">
				{{ $tenancy->service->name }} {{ $tenancy->service->charge_formatted }}
				@if (count($tenancy->service_discounts))
					({{ $tenancy->service_charge_formatted }} with discounts applied)
				@endif
			</span>
		@endslot
		@slot('subTitle')
			{{ $tenancy->property->name }}
		@endslot
	@endcomponent

	<section class="hero is-dark is-bold">
		<div class="hero-body">

			<nav class="level">
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Rent
						</p>
						<p class="title">
							{{ currency($tenancy->rent_amount) }}
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Rent Held
						</p>
						<p class="title">
							{{ currency($tenancy->rent_balance) }}
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Deposit
						</p>
						<p class="title">
							
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Deposit Held
						</p>
						<p class="title">
							
						</p>
					</div>
				</div>
			</nav>
		</div>
	</section>

	@component('partials.sections.section')

		<div class="columns is-flex is-column-mobile side-nav">
			<div class="column is-3">
				<aside class="menu">
					<p class="menu-label">
						Tenancy
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('tenancies.show', $tenancy->id) }}" class="{{ set_active(route('tenancies.show', $tenancy->id)) }}">
								<span class="icon is-small">
									<i class="fa fa-dashboard"></i>
								</span>
								Dashboard
							</a>
							<a href="{{ route('tenancies.show', [$tenancy->id, 'tenants']) }}" class="{{ set_active(route('tenancies.show', [$tenancy->id, 'tenants'])) }}">
								<span class="icon is-small">
									<i class="fa fa-users"></i>
								</span>
								Tenants
							</a>
							<a href="{{ route('tenancies.show', [$tenancy->id, 'rent-amounts']) }}" class="{{ set_active(route('tenancies.show', [$tenancy->id, 'rent-amounts'])) }}">
								<span class="icon is-small">
									<i class="fa fa-university"></i>
								</span>
								Rent Amounts
							</a>
							<a href="{{ route('tenancies.show', [$tenancy->id, 'agreements']) }}" class="{{ set_active(route('tenancies.show', [$tenancy->id, 'agreements'])) }}">
								<span class="icon is-small">
									<i class="fa fa-book"></i>
								</span>
								Agreements
							</a>	
							<a href="{{ route('tenancies.show', [$tenancy->id, 'discounts']) }}" class="{{ set_active(route('tenancies.show', [$tenancy->id, 'discounts'])) }}">
								<span class="icon is-small">
									<i class="fa fa-percent"></i>
								</span>
								Discounts
							</a>
							<a href="{{ route('tenancies.show', [$tenancy->id, 'service']) }}" class="{{ set_active(route('tenancies.show', [$tenancy->id, 'service'])) }}">
								<span class="icon is-small">
									<i class="fa fa-wrench"></i>
								</span>
								Service
							</a>	
						</li>
					</ul>
					<p class="menu-label">
						Actions
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('tenancies.show', [$tenancy->id, 'tenants-vacated']) }}" class="{{ set_active(route('tenancies.show', [$tenancy->id, 'tenants-vacated'])) }}">
								<span class="icon is-small">
									<i class="fa fa-sign-out"></i>
								</span>
								Tenants Vacated
							</a>
							@if ($tenancy->vacated_on)
								<a href="{{ route('tenancies.show', [$tenancy->id, 'archive']) }}" class="{{ set_active(route('tenancies.show', [$tenancy->id, 'archive'])) }}">
									<span class="icon is-small">
										<i class="fa fa-archive"></i>
									</span>
									Finish Tenancy
								</a>
							@endif
						</li>
					</ul>
					<p class="menu-label">
						Statements
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('tenancies.show', [$tenancy->id, 'statements']) }}" class="{{ set_active(route('tenancies.show', [$tenancy->id, 'statements'])) }}">
								Statements
							</a>
							<a href="{{ route('tenancies.show', [$tenancy->id, 'record-old-statement']) }}" class="{{ set_active(route('tenancies.show', [$tenancy->id, 'record-old-statement'])) }}">
								Record Old Statement
							</a>
						</li>
					</ul>
					<p class="menu-label">
						Rent Payments
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('tenancies.show', [$tenancy->id, 'payments']) }}" class="{{ set_active(route('tenancies.show', [$tenancy->id, 'payments'])) }}">
								Rent Payments
							</a>
						</li>
					</ul>
				</aside>
			</div>
			<div class="column is-faded is-9">

				<section class="section">

					<div class="field is-grouped is-grouped-multiline">
						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-medium is-dark">Started</span>
								<span class="tag is-medium is-primary">{{ date_formatted($tenancy->started_at) }}</span>
							</div>
						</div>
						@if ($tenancy->vacated_on)
							<div class="control">
								<div class="tags has-addons">
									<span class="tag is-medium is-dark">Vacated</span>
									<span class="tag is-medium is-primary">{{ date_formatted($tenancy->vacated_on) }}</span>
								</div>
							</div>
						@endif
						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-medium is-dark">Latest Rent Payment</span>
								<span class="tag is-medium is-primary">{{ $tenancy->last_rent_payment ? date_formatted($tenancy->last_rent_payment->created_at) : 'Never' }}</span>
							</div>
						</div>
						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-medium is-dark">Next Statement Due</span>
								<span class="tag is-medium is-primary">{{ date_formatted($tenancy->next_statement_start_date) }}</span>
							</div>
						</div>
					</div>

				</section>

				@yield('sub-content')

			</div>
		</div>

	@endcomponent

@endsection