@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>Invoice #{{ $invoice->number }}</h1>
				<h3>Update the invoice details</h3>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			<form role="form" method="POST" action="{{ route('invoices.update', $invoice->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="form-group">
					<label for="created_at">Date Created</label>
					<input type="date" class="form-control" name="created_at" value="{{ $invoice->created_at->format('Y-m-d') }}" />
				</div>

				<div class="form-group">
					<label for="due_at">Date Due</label>
					<input type="date" class="form-control" name="due_at" value="{{ $invoice->due_at ? $invoice->due_at->format('Y-m-d') : null }}" />
				</div>

				<div class="form-group">
					<label for="number">Number</label>
					<input type="number" class="form-control" name="number" value="{{ $invoice->number }}" />
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

				@component('partials.bootstrap.save-submit-button')
					Save Changes
				@endcomponent

			</form>

		</div>
	</section>

@endsection