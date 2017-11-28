<template>
	<b-table striped hover :items="items"></b-table>
</template>

<script>
	const items = [
		{ isActive: true, age: 40, first_name: 'James', last_name: 'Morris' }
	]

	export default {
		data() {
			return {
				items: items
			}
		}
	}
</script>

@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Email</th>
		<th>Mobile Phone</th>
		<th>Other Phone</th>
		@if (!isset($tenancy))
			<th>Address</th>
		@endif
	@endslot
	@slot('body')
		@foreach ($users as $user)
			<tr>
				<td>
					<a href="{{ route('users.show', $user->id) }}" title="View {{ $user->name }}'s Profile">
						{{ $user->present()->fullName }}
					</a>
				</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->phone_number }}</td>
				<td>{{ $user->phone_number_other }}</td>
				@if (!isset($tenancy))
					<td>{!! $user->present()->locationLink !!}</td>
				@endif
			</tr>
		@endforeach
	@endslot
@endcomponent