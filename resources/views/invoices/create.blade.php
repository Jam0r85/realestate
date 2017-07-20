@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('invoices.index') }}">Invoices</a></li>
	<li class="is-active"><a>Create Invoice</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			Create Invoice
		@endslot
	@endcomponent

	<form role="form" method="POST" action="{{ route('invoices.store') }}">
		{{ csrf_field() }}

		@component('partials.sections.section')

			@include('partials.errors-block')

			<div class="field">
				<label class="label" for="invoice_group_id">Invoice Group</label>
				<p class="control is-expanded">
					<span class="select is-fullwidth">
						<select name="invoice_group_id">
							@foreach (invoiceGroups() as $invoice_group)
								<option value="{{ $invoice_group->id }}">{{ $invoice_group->name }}</option>
							@endforeach
						</select>
					</span>
				</p>
			</div>

			<div class="field">
				<label class="label" for="property_id">Property</label>
				<p class="control is-expanded">
					<select name="property_id" class="select2">
						<option value="" disabled selected></option>
						@foreach (properties() as $property)
							<option value="{{ $property->id }}">{{ $property->name }}</option>
						@endforeach
					</select>
				</p>
			</div>

			<div class="field">
				<label class="label" for="number">Number</label>
				<p class="control">
					<input type="number" name="number" class="input" />
				</p>
				<p class="help">
					You can override the next invoice number of the above group by entering a number manually.
				</p>
			</div>

			<div class="field">
				<label class="label" for="terms">Terms</label>
				<p class="control">
					<textarea name="terms" class="textarea"></textarea>
				</p>
			</div>

			@component('partials.forms.buttons.primary')
				Create Invoice
			@endcomponent

		@endcomponent
	</form>

@endsection