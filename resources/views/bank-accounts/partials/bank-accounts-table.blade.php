@component('partials.table')
	@slot('header')
		<th>Account Name</th>
		<th>Account Number</th>
		<th>Sort Code</th>
		<th>Bank Name</th>
		@if (isset($full))
			<th>Created By</th>
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
					<td>{{ $account->owner->present()->fullName }}</td>
				@endif
				<td class="text-right">
					<a href="{{ route('bank-accounts.show', $account->id) }}" class="btn btn-primary btn-sm">
						@icon('view')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent

@include('partials.pagination', ['collection' => $bank_accounts])