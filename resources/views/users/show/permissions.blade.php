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
				<tr class="row-toggle">
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

@push('footer_scripts')
<script>
	function checkboxRowClass()
	{
		var row = $(this).closest('tr');

		if ($(this).is(':checked')) {
			row.addClass('table-success');
		} else {
			row.removeClass('table-success');
		}
	}

	// Set the correct row classes on page load
	$('input[type=checkbox]:checked').each(function () {
		$(this).closest('tr').addClass('table-success');
	});

	// Toggle the checkbox on row click
	$('.row-toggle').click(function(event) {
		if (event.target.type !== 'checkbox') {
			$(':checkbox', this).trigger('click');
		}
	});

	// Toggle the row class change when the checkbox value is changed
	$(':checkbox').change(checkboxRowClass);
</script>
@endpush