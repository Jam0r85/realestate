<div class="card mb-3">
	@component('partials.card-header')
		Invoice Details
	@endcomponent

	<div class="card-body">

		<form method="POST" action="{{ route('settings.update') }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="form-group">
				<label for="invoice_default_group">Default Invoice Group</label>
				<select name="invoice_default_group" id="invoice_default_group" class="form-control">
					@foreach (invoiceGroups() as $group)
						<option @if (get_setting('invoice_default_group') == $group->id) selected @endif value="{{ $group->id }}">
							{{ $group->name }}
						</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="invoice_default_terms">Default Invoice Terms</label>
				<textarea name="invoice_default_terms" rows="6" class="form-control">{{ get_setting('invoice_default_terms') }}</textarea>
			</div>

			<div class="form-group">
				<label for="invoice_due_after">Invoice Due</label>
				<input type="number" step="any" name="invoice_due_after" id="invoice_due_after" class="form-control" value="{{ get_setting('invoice_due_after') }}">
			</div>

			@component('partials.save-button')
				Save Changes
			@endcomponent

		</form>

	</div>
</div>