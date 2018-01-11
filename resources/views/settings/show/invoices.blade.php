<form method="POST" action="{{ route('settings.update') }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}

	@component('partials.card')
		@slot('header')
			Invoice Details
		@endslot

		<div class="card-body">

			@component('partials.form-group')
				@slot('label')
					Default group
				@endslot
				@slot('help')
					All new invoices will be created for this group unless otherwise stated.
				@endslot
				<select name="invoice_default_group" id="invoice_default_group" class="form-control">
					@foreach (invoiceGroups() as $group)
						<option @if (get_setting('invoice_default_group') == $group->id) selected @endif value="{{ $group->id }}">
							{{ $group->name }}
						</option>
					@endforeach
				</select>
			@endcomponent

			@component('partials.form-group')
				@slot('label')
					Default Invoice Terms
				@endslot
				<textarea name="invoice_default_terms" rows="6" class="form-control">{{ get_setting('invoice_default_terms') }}</textarea>
			@endcomponent

			@component('partials.form-group')
				@slot('label')
					Invoices due after (days)
				@endslot
				@slot('help')
					The number of days to be added to the invoice created date when payment should is due by.
				@endslot
				<input type="number" step="any" name="invoice_due_after" id="invoice_due_after" class="form-control" value="{{ get_setting('invoice_due_after') }}">
			@endcomponent

		</div>

		@slot('footer')
			@component('partials.save-button')
				Save Changes
			@endcomponent
		@endslot

	@endcomponent

</form>