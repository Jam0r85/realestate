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
							@if ($user->email)
								<b>E-Mail</b> - {{ $user->email }}
							@else
								<div class="notification">
									This user does not have an e-mail address.
								</div>
							@endif
						</div>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('users.show', [$user->id, 'update-email']) }}">Edit E-Mail</a>
							<a class="card-footer-item" href="{{ route('users.show', [$user->id, 'send-email']) }}">Send E-Mail Message</a>
						</footer>
					</div>

					<div class="box mb-2">

						<h3 class="title">Properties</h3>
						<h5 class="subtitle">The properties that this user is linked to.</h5>

						<table class="table is-striped is-fullwidth">
							<thead>
								<th>Name</th>
							</thead>
							<tbody>
								@foreach ($user->properties as $property)
									<tr>
										<td><a href="{{ route('properties.show', $property->id) }}">{{ $property->name }}</a></td>
									</tr>
								@endforeach
							</tbody>
						</table>

					</div>

					<div class="box mb-2">

						<h3 class="title">Recent Invoices</h3>
						<h5 class="subtitle">The recent paid and unpaid invoices that this user is linked to.</h5>

						<table class="table is-striped is-fullwidth">
							<thead>
								<th>Number</th>
								<th>Amount</th>
								<th>Balance</th>
								<th>Date</th>
							</thead>
							<tbody>
								@foreach ($user->invoices()->limit(5)->get() as $invoice)
									<tr>
										<td><a href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->number }}</a></td>
										<td>{{ currency($invoice->total) }}</td>
										<td>{{ currency($invoice->total_balance) }}</td>
										<td>{{ date_formatted($invoice->created_at) }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>

					</div>

				</div>
			</div>
		</div>
	</section>

@endsection