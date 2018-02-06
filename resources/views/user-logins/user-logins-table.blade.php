@component('partials.table')
	@slot('header')
		<th>Date</th>
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
				<td>{{ datetime_formatted($login->created_at) }}</td>
				@if (isset($user))
					<td>{{ $login->user->present()->fullName }}</td>
				@endif
				@if (isset($request))
					<td>{{ $login->request['email'] }}</td>
				@endif
				<td>{{ $login->ip }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent