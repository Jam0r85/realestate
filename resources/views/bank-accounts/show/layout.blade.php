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

				</div>
			</div>

		</div>
	</section>

@endsection