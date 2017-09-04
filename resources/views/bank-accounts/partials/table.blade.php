<table class="table table-striped table-responsive">
	<thead>
		<th>Account Name</th>
		<th>Account Number</th>
		<th>Sort Code</th>
		<th>Bank Name</th>
	</thead>
	<tbody>
		@foreach ($accounts as $account)
			<tr>
				<td><a href="{{ route('bank-accounts.show', $account->id) }}">{{ $account->account_name }}</a></td>
				<td>{{ $account->account_number }}</td>
				<td>{{ $account->sort_code }}</td>
				<td>{{ $account->bank_name }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $accounts])