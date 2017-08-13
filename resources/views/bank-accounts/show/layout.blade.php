@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">{{ $account->account_name }}</h1>

			{{-- Show the users --}}
			<div class="control">
				<a href="{{ route('bank-accounts.show', [$account->id, 'edit-users']) }}" class="button is-warning">
					<span class="icon is-small">
						<i class="fa fa-edit"></i>
					</span>
					<span>
						Edit Users
					</span>
				</a>
				@foreach ($account->users as $user)
					<a href="{{ route('users.show', $user->id) }}">
						<span class="tag is-medium is-primary">
							{{ $user->name }}
						</span>
					</a>
				@endforeach
			</div>

			<hr />

			<div class="columns">
				<div class="column is-4">

					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								Account Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="has-text-grey">Bank</td>
								<td class="has-text-right">{{ $account->bank_name }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Account Name</td>
								<td class="has-text-right">{{ $account->account_name }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Sort Code</td>
								<td class="has-text-right">{{ $account->sort_code }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Number</td>
								<td class="has-text-right">{{ $account->account_number }}</td>
							</tr>
						</table>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('bank-accounts.show', [$account->id, 'edit-details']) }}">Edit Details</a>	
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
								<td class="has-text-grey">Created By</td>
								<td class="has-text-right"><a href="{{ route('users.show', $account->owner->id) }}">{{ $account->owner->name }}</a></td>
							</tr>
							<tr>
								<td class="has-text-grey">Created On</td>
								<td class="has-text-right">{{ date_formatted($account->created_at) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Last Updated On</td>
								<td class="has-text-right">{{ date_formatted($account->updated_at) }}</td>
							</tr>
							@if ($account->deleted_at)
								<tr>
									<td class="has-text-grey">Archived On</td>
									<td class="has-text-right">{{ date_formatted($account->deleted_at) }}</td>
								</tr>
							@endif
						</table>
					</div>

				</div>
				<div class="column is-8">

					@if (count($account->properties))
						<div class="card mb-2">
							<div class="card-content">

								<h3 class="title">Properties</h3>
								<h5 class="subtitle">The properties that currently linked to this bank account.</h5>

								<table class="table is-striped is-fullwidth">
									<thead>
										<th>Name</th>
									</thead>
									<tbody>
										@foreach ($account->properties as $property)
											<tr>
												<td><a href="{{ route('properties.show', $property->id) }}">{{ $property->name }}</a></td>
											</tr>
										@endforeach
									</tbody>
								</table>

							</div>
						</div>
					@endif

					@if (count($account->statement_payments))
						<div class="card">
							<div class="card-content">

								<h3 class="title">Recent Statement Payments</h3>
								<h5 class="subtitle">The statement payments that have been sent to this bank account.</h5>

								<table class="table is-striped is-fullwidth">
									<thead>
										<th>Sent</th>
										<th>Tenancy</th>
										<th>Name</th>
										<th>Amount</th>
									</thead>
									<tbody>
										@foreach ($account->recent_statement_payments as $payment)
											<tr>
												<td>{{ $payment->sent_at ? date_formatted($payment->sent_at) : 'Not Sent' }}</td>
												<td><a href="{{ route('tenancies.show', $payment->statement->tenancy->id) }}">{{ $payment->statement->tenancy->name }}</a></td>
												<td>{{ $payment->name_formatted }}</td>
												<td>{{ currency($payment->amount) }}</td>
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

@endsection