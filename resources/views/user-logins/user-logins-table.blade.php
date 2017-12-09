@component('partials.table')
	@slot('header')
		<th>Date</th>
		<th>Time</th>
		@if (isset($user))
			<th>User</th>
		@endif
		@if (isset($request))
			<th>E-Mail</th>
			<th>Password</th>
		@endif
		<th>IP</th>
	@endslot
	@slot('body')
		@foreach ($logins as $login)
			<tr>
				<td>{{ date_formatted($login->created_at) }}</td>
				<td>{{ time_formatted($login->created_at) }}</td>
				@if (isset($user))
					<td>{{ $login->user->present()->fullName }}</td>
				@endif
				@if (isset($request))
					<td>{{ $login->request['email'] }}</td>
					<td>{{ $login->request['password'] }}</td>
				@endif
				<td>{{ $login->ip }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent