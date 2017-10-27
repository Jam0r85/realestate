@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('statements.show', $statement->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				Statement #{{ $statement->id }}
			@endcomponent

			@component('partials.sub-header')
				Update statement details
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3">

			@component('partials.bootstrap.card-header')
				Statement Details
			@endcomponent

			<div class="card-body">

				<form method="POST" action="{{ route('statements.update', $statement->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					<div class="form-group">
						<label for="created_at">Created</label>
						<input type="date" name="created_at" id="created_at" class="form-control" value="{{ $statement->created_at->format('Y-m-d') }}" />
					</div>

					<div class="form-group">
						<label for="period_start">Date From</label>
						<input type="date" name="period_start" id="period_start" class="form-control" value="{{ $statement->period_start->format('Y-m-d') }}" />
					</div>

					<div class="form-group">
						<label for="period_end">Date End</label>
						<input type="date" name="period_end" id="period_end" class="form-control" value="{{ $statement->period_end->format('Y-m-d') }}" />
					</div>

					<div class="form-group">
						<label for="amount">Statement Amount</label>
						<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ $statement->amount }}" />
					</div>

					@component('partials.save-button')
						Save Changes
					@endcomponent

				</form>

			</div>
		</div>

		<div class="card mb-3">

			@component('partials.bootstrap.card-header')
				Change Bank Account
			@endcomponent

			<div class="card-body">

				<div class="form-group">
					<label for="bank_account_id">Bank Account</label>
					<select name="bank_account_id" id="bank_account_id" class="form-control">
						<option value="0">None</option>
						@foreach (bank_accounts($statement->property->owners->pluck('id')->toArray()) as $account)
							<option @if ($statement->property->bank_account_id == $account->id) selected @endif value="{{ $account->id }}">{{ $account->name }}</option>
						@endforeach
					</select>
				</div>

			</div>
		</div>

		<div class="card mb-3">

			@component('partials.bootstrap.card-header')
				Change Method of Sending
			@endcomponent

			<div class="card-body">

				<div class="form-control">
					<label for="sending_method">Sending Method</label>
					<select name="sending_method" id="sending_method" class="form-control">
						<option @if ($statement->property->hasSetting('post_rental_statement')) selected @endif value="post">By Post</option>
						<option @if (!$statement->property->hasSetting('post_rental_statement')) selected @endif value="email">By E-Mail</option>
					</select>
				</div>

			</div>
		</div>

	@endcomponent

@endsection