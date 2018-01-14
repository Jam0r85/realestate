@component('partials.form-group')
	@slot('label')
		Name
	@endslot
	<input type="text" name="name" id="name" class="form-control" value="{{ isset($calendar) ? $calendar->name : old('name') }}" required />
@endcomponent

@component('partials.form-group')
	@slot('label')
		Branch
	@endslot
	<select name="branch_id" id="branch_id" class="form-control" required>
		<option value="" selected>Please select..</option>
		@foreach (common('branches') as $branch)
			<option @if (isset($calendar) && $calendar->branch_id == $branch->id) selected @endif value="{{ $branch->id }}">
				{{ $branch->name }}
			</option>
		@endforeach
	</select>
@endcomponent