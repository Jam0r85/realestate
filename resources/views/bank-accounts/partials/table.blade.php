@component('partials.table')
	@slot('head')
		<th>Account Name</th>
		<th>Account Number</th>
		<th>Sort Code</th>
		<th>Bank Name</th>
	@endslot
	@foreach ($accounts as $account)
		<tr>
			<td><a href="{{ route('bank-accounts.show', $account->id) }}">{{ $account->account_name }}</a></td>
			<td>{{ $account->account_number }}</td>
			<td>{{ $account->sort_code }}</td>
			<td>{{ $account->bank_name }}</td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $accounts])