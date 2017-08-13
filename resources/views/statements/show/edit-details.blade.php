@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('statements.show', $statement->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">Statement #{{ $statement->id}}</h1>
			<h2 class="subtitle">Update details</h2>

			<hr />

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('statements.update', $statement->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="field">
					<label class="label" for="created_at">Created</label>
					<p class="control">
						<input type="date" name="created_at" class="input" value="{{ $statement->created_at->format('Y-m-d') }}" />
					</p>
				</div>

				<div class="field">
					<label class="label" for="period_start">Date From</label>
					<p class="control">
						<input type="date" name="period_start" class="input" value="{{ $statement->period_start->format('Y-m-d') }}" />
					</p>
				</div>

				<div class="field">
					<label class="label" for="period_end">Date End</label>
					<p class="control">
						<input type="date" name="period_end" class="input" value="{{ $statement->period_end->format('Y-m-d') }}" />
					</p>
				</div>

				<div class="field">
					<label class="label" for="amount">Statement Amount</label>
					<p class="control">
						<input type="number" step="any" name="amount" class="input" value="{{ $statement->amount }}" />
					</p>
				</div>

				<div class="field">
					<label class="label" for="bank_account_id">Bank Account</label>
					<div class="control">
						<select name="bank_account_id" class="select2">
							<option value="0">None</option>
							@foreach (bank_accounts($statement->property->owners->pluck('id')->toArray()) as $account)
								<option @if ($statement->property->bank_account_id == $account->id) selected @endif value="{{ $account->id }}">{{ $account->name }}</option>
							@endforeach
						</select>
					</div>
					<p class="help">
						<b>Please note:</b> Changing this will also update the default property setting.
					</p>
				</div>

				<div class="field">
					<label class="label" for="sending_method">Sending Method</label>
					<div class="control">
						<span class="select is-fullwidth">
							<select name="sending_method">
								<option @if ($statement->property->hasSetting('post_rental_statement')) selected @endif value="post">By Post</option>
								<option @if (!$statement->property->hasSetting('post_rental_statement')) selected @endif value="email">By E-Mail</option>
							</select>
						</span>
					</div>
					<p class="help">
						<b>Please note</b>: Changing this will also update the default property setting.
					</p>
				</div>

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Save Changes
					</span>
				</button>

			</form>

		</div>
	</section>
	
	<section class="section">
		<div class="container">

			<h2 class="subtitle">Mark {{ isset($statement->paid_at) ? 'Unpaid' : 'Paid' }}</h2>

			<hr />

			<div class="content">

				<p>
					You can mark this statement as being paid or unpaid without actually sending any payments. <b>Note:</b> If no payments have been generated for this statement that will be created automatically when submitting the form.
				</p>

				@if ($statement->paid_at)
					<p>
						<b>The statement was paid on {{ date_formatted($statement->paid_at) }}</b>
					</p>
				@endif

			</div>

			<hr />

			<form role="form" method="POST" action="{{ route('statements.toggle-paid', $statement->id) }}">
				{{ csrf_field() }}

				<button type="submit" class="button is-outlined {{ isset($statement->paid_at) ? 'is-danger' : 'is-success' }}">
					Mark {{ isset($statement->paid_at) ? 'Unpaid' : 'Paid' }}
				</button>

			</form>

		</div>
	</section>

	@component('partials.sections.section-no-container')

		@component('partials.subtitle')
			Mark {{ isset($statement->sent_at) ? 'Unsent' : 'Sent' }}
		@endcomponent

		<div class="content">
			<p>
				You can mark this statement as being sent without sending it to the owners or mark it as being unsent again.
			</p>

			@if ($statement->sent_at)
				<p>
					<b>The statement was sent to the owners on {{ date_formatted($statement->sent_at) }}</b>
				</p>
			@endif

		</div>

		<hr />

		<form role="form" method="POST" action="{{ route('statements.toggle-sent', $statement->id) }}">
			{{ csrf_field() }}

			<button type="submit" class="button is-outlined {{ isset($statement->sent_at) ? 'is-danger' : 'is-success' }}">
				Mark {{ isset($statement->sent_at) ? 'Unsent' : 'Sent' }}
			</button>

		</form>

	@endcomponent

@endsection