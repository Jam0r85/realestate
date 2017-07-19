<div class="field">
	<label class="label" for="name">Name</label>
	<p class="control">
		<input type="text" name="name" class="input" value="{{ isset($invoice_group) ? $invoice_group->name : old('name') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="next_number">Starting Number</label>
	<p class="control">
		<input type="number" name="next_number" class="input" value="{{ isset($invoice_group) ? $invoice_group->next_number : old('next_number') ?: 1 }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="format">Number Format</label>
	<p class="control">
		<input type="text" name="format" class="input" value="{{ isset($invoice_group) ? $invoice_group->format : old('format') ?: '[[number]]' }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="branch_id">Branch</label>
	<p class="control is-expanded">
		<span class="select is-fullwidth">
			<select name="branch_id">
				<option value="" selected disabled>Please select..</option>
				@foreach (branches() as $branch)
					<option @if (isset($invoice_group) && $invoice_group->branch_id == $branch->id) selected @endif value="{{ $branch->id }}">{{ $branch->name }}</option>
				@endforeach
			</select>
		</span>
	</p>
</div>