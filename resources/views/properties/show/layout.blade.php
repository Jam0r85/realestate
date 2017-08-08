@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">{{ $property->name }}</h1>

			{{-- Show the owners --}}
			@if (count($property->owners))
				<p>Current Owners:
					@foreach ($property->owners as $owner)
						<a href="{{ route('users.show', $owner->id) }}">
							<span class="tag is-medium @if ($owner->property_id == $property->id) is-success @else is-primary @endif">
								{{ $owner->name }}
							</span>
						</a>
					@endforeach
				</p>
			@endif

		</div>
	</section>

	<section class="section">
		<div class="container">

			<div class="columns">
				<div class="column is-4">

					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								Property Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="has-text-grey">House Name</td>
								<td class="has-text-right">{{ $property->house_name }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">House Number</td>
								<td class="has-text-right">{{ $property->house_number }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Line 1</td>
								<td class="has-text-right">{{ $property->address1 }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Line 2</td>
								<td class="has-text-right">{{ $property->address2 }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Line 3</td>
								<td class="has-text-right">{{ $property->address3 }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Town</td>
								<td class="has-text-right">{{ $property->town }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Postcode</td>
								<td class="has-text-right">{{ $property->postcode }}</td>
							</tr>
						</table>
						<footer class="card-footer">
							<a class="card-footer-item">Edit</a>
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
								<td class="has-text-grey">Created On</td>
								<td class="has-text-right">{{ date_formatted($property->created_at) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Last Updated On</td>
								<td class="has-text-right">{{ date_formatted($property->updated_at) }}</td>
							</tr>
						</table>
					</div>

				</div>
				<div class="column is-8">

					@if (count($property->tenancies))
						<div class="card mb-2">
							<div class="card-content">
								<h3 class="title">Tenancies</h3>
								<h5 class="subtitle">The following tenancies are registered to this property.</h5>

								<table class="table is-fullwidth is-striped">
									<thead>
										<th>Name</th>
										<th>Rent</th>
										<th>Started</th>
										<th>Status</th>
									</thead>
									<tbody>
										@foreach ($property->tenancies as $tenancy)
											<tr>
												<td><a href="{{ route('tenancies.show', $tenancy->id) }}">{{ $tenancy->name }}</a></td>
												<td>{{ currency($tenancy->rent_amount) }}</td>
												<td>{{ date_formatted($tenancy->started_at) }}</td>
												<td>
													<span class="tag is-medium {{ $tenancy->vacated_on ? 'is-warning' : 'is-success' }}">
														{{ $tenancy->vacated_on ? 'Vacated' : 'Active' }}
													</span>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					@endif

					@if (count($property->recent_statements))
						<div class="card mb-2">
							<div class="card-content">
								<h3 class="title">Statements</h3>
								<h5 class="subtitle">The following statements are registered to this property.</h5>

								<table class="table is-fullwidth is-striped">
									<thead>
										<th>Period</th>
										<th>Tenancy</th>
										<th>Amount</th>
										<th>Status</th>
									</thead>
									<tbody>
										@foreach ($property->recent_statements as $statement)
											<tr>
												<td><a href="{{ route('statements.show', $statement->id) }}">{{ $statement->period_formatted }}</a></td>
												<td>{{ $statement->tenancy->name }}</td>
												<td>{{ currency($statement->amount) }}</td>
												<td>
													<span class="tag is-medium {{ $statement->sent_at ? 'is-success' : 'is-danger' }}">
														{{ $statement->sent_at ? 'Sent' : 'Unsent' }}
													</span>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					@endif

					@if (count($property->recent_invoices))
						<div class="card mb-2">
							<div class="card-content">
								<h3 class="title">Recent Invoices</h3>
								<h5 class="subtitle">The following invoices are the most recent for this property.</h5>

								<table class="table is-fullwidth is-striped">
									<thead>
										<th>Number</th>
										<th>Total</th>
										<th>Created</th>
										<th>Status</th>
									</thead>
									<tbody>
										@foreach ($property->recent_invoices as $invoice)
											<tr>
												<td><a href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->number }}</a></td>
												<td>{{ currency($invoice->total) }}</td>
												<td>{{ date_formatted($invoice->created_at) }}</td>
												<td>
													<span class="tag is-medium {{ $invoice->paid_at ? 'is-success' : 'is-danger' }}">
														{{ $invoice->paid_at ? 'Paid' : 'Unpaid' }}
													</span>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					@endif

				</div>
			</div>
		</div>
	</section>

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
							<a href="{{ route('properties.show', [$property->id, 'statement-settings']) }}" class="{{ set_active(route('properties.show', [$property->id, 'statement-settings'])) }}">
								Statement Settings
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