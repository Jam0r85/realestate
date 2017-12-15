@component('partials.table')
	@slot('header')
		<th>Account Name</th>
		<th>Account Number</th>
		<th>Sort Code</th>
		<th>Bank Name</th>
		@if (isset($full))
			<th>Created</th>
			<th>Created By</th>
		@endif
		@if (isset($archived))
			<th class="text-right">Archived</th>
		@endif
		<th></th>
	@endslot
	@slot('body')
		@foreach ($bank_accounts as $account)
			<tr>
				<td>{{ $account->account_name }}</td>
				<td>{{ $account->account_number }}</td>
				<td>{{ $account->sort_code }}</td>
				<td>{{ $account->bank_name }}</td>
				@if (isset($full))
					<td>{{ date_formatted($account->created_at) }}</td>
					<td>{{ $account->owner->present()->fullName }}</td>
				@endif
				@if (isset($archived))
					<td class="text-right">
						{{ date_formatted($account->deleted_at) }}
					</td>
				@endif
				<td class="text-right">
					<a href="{{ route('bank-accounts.show', $account->id) }}" class="btn btn-primary btn-sm">
						View
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent

@include('partials.pagination', ['collection' => $bank_accounts])