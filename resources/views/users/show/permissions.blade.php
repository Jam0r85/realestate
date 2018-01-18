@if ($user->isSuperAdmin())
	@component('partials.alerts.danger')
		@icon('info') The below permissions do not apply as this user is a Super Admin.
	@endcomponent
@endif

<form method="POST" action="{{ route('users.update-permissions', $user->id) }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}

	@component('partials.table')
		@slot('header')
			<th>Name</th>
			<th>Description</th>
			<th></th>
		@endslot
		@slot('body')
			@foreach (common('permissions') as $permission)
				<tr>
					<td>
						<label for="{{ $permission->slug }}">
							{{ $permission->name }}
						</label>
					</td>
					<td>{{ $permission->description }}</td>
					<td class="text-right">
						<input @if ($user->isSuperAdmin()) disabled @endif type="hidden" name="{{ $permission->slug }}" value="" />
						<input @if ($user->isSuperAdmin()) disabled @endif @if ($user->permissions->contains($permission->id)) checked @endif type="checkbox" name="{{ $permission->slug }}" id="{{ $permission->slug }}" value="true" />
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent

	@if (! $user->isSuperAdmin())
		@component('partials.save-button')
			Save Changes
		@endcomponent
	@endif

</form>