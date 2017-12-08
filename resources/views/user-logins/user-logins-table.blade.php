@component('partials.table')
	@slot('header')
		<th>Date</th>
		<th>Time</th>
		<th>User</th>
		<th>IP</th>
	@endslot
	@slot('body')
		@foreach ($logins as $login)
			<tr>
				<td>{{ date_formatted($login->created_at) }}</td>
				<td>{{ time_formatted($login->created_at) }}</td>
				<td>{{ $login->user->present()->fullName }}</td>
				<td>{{ $login->ip }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent