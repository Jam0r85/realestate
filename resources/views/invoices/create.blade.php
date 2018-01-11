@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Invoice
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')


		<form method="POST" action="{{ route('invoices.store') }}">
			{{ csrf_field() }}

			@component('partials.card')

				<div class="card-body">

					@component('partials.form-group')
						@slot('label')
							Date
						@endslot
						<input type="date" name="created_at" id="created_at" class="form-control" value="{{ old('created_at') ?? \Carbon\Carbon::now()->format('Y-m-d') }}" />
					@endcomponent

					@component('partials.form-group')
						@slot('label')
							Invoice Group
						@endslot
						<select name="invoice_group_id" class="form-control">
							@foreach (invoiceGroups() as $invoice_group)
								<option @if (old('invoice_group_id') == $invoice_group->id) selected @endif value="{{ $invoice_group->id }}">{{ $invoice_group->name }}</option>
							@endforeach
						</select>
					@endcomponent

					@component('partials.form-group')
						@slot('label')
							Property
						@endslot
						<select name="property_id" class="form-control select2">
							<option value="0" selected>None</option>
							@foreach (properties() as $property)
								<option @if (old('property_id') == $property->id) selected @endif value="{{ $property->id }}">
									{{ $property->present()->selectName }}
								</option>
							@endforeach
						</select>
					@endcomponent

					@component('partials.form-group')
						@slot('label')
							Attach Users
						@endslot
						<select name="users[]" class="form-control select2" multiple>
							@foreach (users() as $user)
								<option @if (old('users') && in_array($user->id, old('users'))) selected @endif value="{{ $user->id }}">
									{{ $user->present()->selectName }}
								</option>
							@endforeach
						</select>
					@endcomponent

					@component('partials.form-group')
						@slot('label')
							Invoice Number
						@endslot
						@slot('help')
							Manually enter an invoice number if required.
						@endslot
						<input type="text" name="number" class="form-control" value="{{ old('number') }}" />
					@endcomponent

					@component('partials.form-group')
						@slot('label')
							Terms
						@endslot
						<textarea name="terms" id="terms" class="form-control" rows="7">{{ old('terms') ?? get_setting('invoice_default_terms') }}</textarea>
					@endcomponent

				</div>

				@slot('footer')
					@component('partials.save-button')
						Create Invoice
					@endcomponent
				@endslot
				
			@endcomponent

		</form>

	@endcomponent

@endsection