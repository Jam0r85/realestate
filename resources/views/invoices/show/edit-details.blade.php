@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				Invoice #{{ $invoice->number }}
			@endcomponent

			@component('partials.sub-header')
				Update the invoice details
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="form-group">
				<label for="property_id">Property</label>
				<select name="property_id" id="property_id" class="form-control select2">
					@foreach (properties() as $property)
						<option @if ($invoice->property_id == $property->id) selected @endif value="{{ $property->id }}">
							{{ $property->name }}
							@if (count($property->owners))
								({{ implode(', ', $property->owners->pluck('name')->toArray()) }})
							@endif
						</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="created_at">Date Created</label>
				<input type="date" class="form-control" name="created_at" value="{{ $invoice->created_at->format('Y-m-d') }}" />
			</div>

			<div class="form-group">
				<label for="due_at">Date Due</label>
				<input type="date" class="form-control" name="due_at" value="{{ $invoice->due_at ? $invoice->due_at->format('Y-m-d') : null }}" />
			</div>

			@if ($invoice->paid_at)
				<div class="form-group">
					<label for="paid_at">Date Paid</label>
					<input type="date" class="form-control" name="paid_at" value="{{ $invoice->paid_at->format('Y-m-d') }}" />
				</div>
			@endif

			<div class="form-group">
				<label for="number">Number</label>
				<input type="text" class="form-control" name="number" value="{{ $invoice->number }}" />
			</div>

			<div class="form-group">
				<label for="users">Users</label>
				<select name="users[]" class="form-control select2" multiple>
					@foreach (users() as $user)
						<option @if ($invoice->users->contains($user->id)) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="recipient">Recipient</label>
				<textarea @if ($invoice->statement) disabled @endif name="recipient" class="form-control" rows="5">{{ $invoice->recipient }}</textarea>
				@if ($invoice->statement)
					<small class="form-text text-danger">
						This invoice is attached to a rental statement and will inherit the rental statement's address.
					</small>
				@else
					<small class="form-text text-muted">
						Enter the recipient address for this invoice. If the invoice has users attached to it, their names will automatically be added above the address for you.
					</small>
				@endif
			</div>

			<div class="form-group">
				<label for="terms">Terms</label>
				<textarea name="terms" class="form-control" rows="5">{{ $invoice->terms }}</textarea>
			</div>

			@component('partials.save-button')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection