@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('invoices.show', $invoice->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">Invoice #{{ $invoice->number }}</h1>
			<h2 class="subtitle">Update details</h2>

			<hr />

			<form role="form" method="POST" action="{{ route('invoices.update', $invoice->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="field">
					<label class="label" for="created_at">Date Created</label>
					<p class="control">
						<input type="date" class="input" name="created_at" value="{{ $invoice->created_at->format('Y-m-d') }}" />
					</p>
				</div>

				<div class="field">
					<label class="label" for="due_at">Date Due</label>
					<p class="control">
						<input type="date" class="input" name="due_at" value="{{ $invoice->due_at ? $invoice->due_at->format('Y-m-d') : null }}" />
					</p>
				</div>

				<div class="field">
					<label class="label" for="number">Number</label>
					<p class="control">
						<input type="number" class="input" name="number" value="{{ $invoice->number }}" />
					</p>
				</div>

				<div class="field">
					<label class="label" for="users">Users</label>
					<p class="control ix-expanded">
						<select name="users[]" class="select2" multiple>
							@foreach (users() as $user)
								<option @if ($invoice->users->contains($user->id)) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
							@endforeach
						</select>
					</p>
				</div>

				<div class="field">
					<label class="label" for="recipient">Recipient</label>
					<p class="control">
						<textarea name="recipient" class="textarea">{{ $invoice->recipient }}</textarea>
					</p>
				</div>

				<div class="field">
					<label class="label" for="terms">Terms</label>
					<p class="control">
						<textarea name="terms" class="textarea">{{ $invoice->terms }}</textarea>
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

@endsection