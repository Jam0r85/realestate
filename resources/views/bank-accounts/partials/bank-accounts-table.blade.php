@component('partials.table')
	@slot('header')
		<th>Account Name</th>
		<th>Account Number</th>
		<th>Sort Code</th>
		<th>Bank Name</th>
		@if (isset($archived))
			<th class="text-right">Archived</th>
		@endif
	@endslot
	@slot('body')
		@foreach ($accounts as $account)
			<tr>
				<td><a href="{{ route('bank-accounts.show', $account->id) }}">{{ $account->account_name }}</a></td>
				<td>{{ $account->account_number }}</td>
				<td>{{ $account->sort_code }}</td>
				<td>{{ $account->bank_name }}</td>
				@if (isset($archived))
					<td class="text-right">
						{{ date_formatted($account->deleted_at) }}
					</td>
				@endif
			</tr>
		@endforeach
	@endslot
@endcomponent

@include('partials.pagination', ['collection' => $accounts])