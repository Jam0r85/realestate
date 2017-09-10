@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<div class="float-right">
					@include('tenancies.partials.dropdown-menus')
				</div>
				<h1>{{ $tenancy->name }}</h1>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			<div class="row">
				<div class="col col-5">

					@include('tenancies.partials.tenants-card')
					@include('tenancies.partials.system-info-card')

				</div>
				<div class="col col-7">

					@include('tenancies.partials.rent-info-card')
					@include('tenancies.partials.service-card')
					@include('tenancies.partials.agreement-card')

				</div>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

				<h2 class="subtitle">
					<a href="{{ route('properties.show', $tenancy->property->id) }}">
						{{ $tenancy->property->name }}
					</a>
				</h2>

			<div class="control">
				<a href="{{ route('tenancies.show', [$tenancy->id, 'edit-tenants']) }}" class="button is-warning">
					<span class="icon is-small">
						<i class="fa fa-edit"></i>
					</span>
					<span>
						Edit Tenants
					</span>
				</a>
				@foreach ($tenancy->tenants as $user)
					<a href="{{ route('users.show', $user->id) }}">
						<span class="tag is-medium is-primary">
							{{ $user->name }}
						</span>
					</a>
				@endforeach
			</div>

			<hr />

			@include('tenancies.partials.layout-notices')

			<div class="columns">
				<div class="column is-one-quarter-desktop is-one-third-tablet">

					{{-- Tenancy Details Card --}}
					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								Tenancy Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="is-muted">Started</td>
								<td class="has-text-right">
									{{ $tenancy->first_agreement ? date_formatted($tenancy->first_agreement->starts_at) : 'Not Started' }}
								</td>
							</tr>
							@if ($tenancy->vacated_on)
								<tr>
									<td class="is-muted">Vacated</td>
									<td class="has-text-right">{{ date_formatted($tenancy->vacated_on) }}
									</td>
								</tr>
							@endif
							<tr>
								<td class="is-muted">Service</td>
								<td class="has-text-right">{{ $tenancy->service->name }}</td>
							</tr>
							<tr>
								<td class="is-muted">Service Charge</td>
								<td class="has-text-right">{{ $tenancy->service_charge_formatted }} <span class="tag is-primary">{{ currency($tenancy->service_charge_amount) }}</span></td>
							</tr>
						</table>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('tenancies.show', [$tenancy->id, 'vacated']) }}">
								Vacated
							</a>
						</footer>
					</div>

					{{-- Rent Details Card --}}
					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								Rent Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="is-muted">Date Set</td>
								<td class="has-text-right">
									{{ $tenancy->current_rent ? date_formatted($tenancy->current_rent->starts_at) : 'No Rent Set' }}
								</td>
							</tr>
							<tr>
								<td class="is-muted">Rent PCM</td>
								<td class="has-text-right">
									{{ $tenancy->current_rent ? currency($tenancy->current_rent->amount) : 'n/a' }}
								</td>
							</tr>
						</table>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('tenancies.show', [$tenancy->id, 'new-rent-amount']) }}">
								New
							</a>
							<a class="card-footer-item" href="{{ route('tenancies.show', [$tenancy->id, 'rent-amount-history']) }}">
								History
							</a>
						</footer>
					</div>

					{{-- Agreement Details Card --}}
					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								Agreement Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="is-muted">Started</td>
								<td class="has-text-right">
									{{ $tenancy->current_agreement ? date_formatted($tenancy->current_agreement->starts_at) : 'No Active Agreement' }}
								</td>
							</tr>
							@if ($tenancy->current_agreement)
								<tr>
									<td class="is-muted">Length</td>
									<td class="has-text-right">
										{{ $tenancy->current_agreement->length_formatted }}
									</td>
								</tr>
								<tr>
									<td class="is-muted">Ends</td>
									<td class="has-text-right">
										{{ $tenancy->current_agreement->ends_at_formatted }}
									</td>
								</tr>
							@endif
						</table>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('tenancies.show', [$tenancy->id, 'new-agreement']) }}">
								New
							</a>
							<a class="card-footer-item" href="{{ route('tenancies.show', [$tenancy->id, 'agreement-history']) }}">
								History
							</a>
						</footer>
					</div>

				</div>
				<div class="column">

					<div class="tiles mb-2">
						<div class="tile is-ancestor">
							{{-- Record Rent Payment Card --}}
							<div class="tile is-parent is-half">
								<div class="tile is-child box">

									<span class="tag is-primary is-medium is-pulled-right">
										{{ currency($tenancy->rent_balance) }}
									</span>

									<h3 class="title">Record Rent Payment</h3>

									<form role="form" method="POST" action="{{ route('tenancies.create-rent-payment', $tenancy->id) }}">
										{{ csrf_field() }}

										@include('tenancies.partials.payment-form')

										<button type="submit" class="button is-primary">
											<span class="icon is-small">
												<i class="fa fa-save"></i>
											</span>
											<span>
												Record Payment
											</span>
										</button>

									</form>

								</div>
							</div>
							{{-- Create Statement Card --}}
							<div class="tile is-parent is-half">
								<div class="tile is-child box">

									<h3 class="title">Create Statement</h3>

									<form role="form" method="POST" action="{{ route('tenancies.create-rental-statement', $tenancy->id) }}">
										{{ csrf_field() }}

										@include('tenancies.partials.statement-form')

										<button type="submit" class="button is-primary">
											<span class="icon is-small">
												<i class="fa fa-save"></i>
											</span>
											<span>
												Create Statement
											</span>
										</button>

									</form>

								</div>
							</div>
						</div>
					</div>

					{{-- Recent Rent Payments Card --}}
					<div class="card mb-2">
						<div class="card-content">

							<h3 class="title">Latest Rent Payments</h3>
							<h5 class="subtitle">List of the latest rent payments recorded against this tenancy.</h5>

							<table class="table is-striped is-fullwidth">
								<thead>
									<th>Date</th>
									<th>Amount</th>
									<th>Method</th>
									<th>User(s)</th>
								</thead>
								<tbody>
									@foreach ($tenancy->rent_payments()->limit(5)->get() as $payment)
										<tr>
											<td>
												<a href="{{ route('payments.show', $payment->id) }}">
													{{ date_formatted($payment->created_at) }}
												</a>
											</td>
											<td>{{ currency($payment->amount) }}</td>
											<td>{{ $payment->method->name }}</td>
											<td>
												@foreach ($payment->users as $user)
													<span class="tag is-primary">
														{{ $user->name }}
													</span>
												@endforeach
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>

						</div>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('tenancies.show', [$tenancy->id, 'payments']) }}">
								Rent Payments List
							</a>
						</footer>
					</div>

					{{-- Recent Statements Card --}}
					<div class="card mb-2">
						<div class="card-content">

							<h3 class="title">Latest Statements</h3>
							<h5 class="subtitle">List of the latest statements generated for this tenancy.</h5>

							<table class="table is-striped is-fullwidth">
								<thead>
									<th>Date</th>
									<th>Starts</th>
									<th>Ends</th>
									<th>Amount</th>
									<th>Invoice</th>
								</thead>
								<tbody>
									@foreach ($tenancy->statements()->limit(5)->get() as $statement)
										<tr>
											<td>
												<a href="{{ route('statements.show', $statement->id) }}">
													{{ date_formatted($statement->created_at) }}
												</a>
											</td>
											<td>{{ date_formatted($statement->period_start) }}</td>
											<td>{{ date_formatted($statement->period_end) }}</td>
											<td>{{ currency($statement->amount) }}</td>
											<td>
												@if ($statement->hasInvoice())
													<a href="{{ route('invoices.show', $statement->invoice->id) }}">
														{{ $statement->invoice->number }}
													</a>
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>

						</div>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('tenancies.show', [$tenancy->id, 'statements']) }}">
								Statements List
							</a>
							<a class="card-footer-item" href="{{ route('tenancies.show', [$tenancy->id, 'record-old-statement']) }}">
								Record Old Statement
							</a>
						</footer>
					</div>



				</div>
			</div>

		</div>
	</section>

@endsection