@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('bank-accounts.show', $account->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $account->account_name }}
		@endcomponent

		@component('partials.sub-header')
			Edit Account Details
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		@component('partials.alerts.info')
			<h5>
				@icon('info') <b>Important</b>
			</h5>
			When a landlord changes their bank account you should archive their current account and create a new one.
		@endcomponent

		<div class="row">
			<div class="col-sm-12 col-lg-6">

				<form method="POST" action="{{ route('bank-accounts.update', $account->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					<div class="card mb-3">

						@component('partials.card-header')
							Bank Account Details
						@endcomponent

						<div class="card-body">

							@include('bank-accounts.partials.form')

							@component('partials.form-group')
								@slot('label')
									Attached Users
								@endslot
								<select name="users[]" id="users" class="form-control select2" multiple>
									@foreach (users() as $user)
										<option @if ($account->users->contains($user->id)) selected @endif value="{{ $user->id }}">
											{{ $user->present()->selectName }}
										</option>
									@endforeach
								</select>
							@endcomponent

						</div>
						<div class="card-footer">
							@component('partials.save-button')
								Save Changes
								@if ($account->trashed())
									@slot('disabled')
										You cannot edit an archived account
									@endslot
								@endif
							@endcomponent
						</div>
					</div>

				</form>

			</div>
			<div class="col-sm-12 col-lg-6">

				@if ($account->deleted_at)

					<form method="POST" action="{{ route('bank-accounts.restore', $account->id) }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}

						<div class="card mb-3">

							@component('partials.card-header')
								Restore Bank Account
							@endcomponent

							<div class="card-body">

								<p class="card-text">
									You can restore this bank account allowing it to be used again.
								</p>

							</div>
							<div class="card-footer">
								@component('partials.save-button')
									Restore Bank Account
								@endcomponent
							</div>
						</div>

					</form>

				@else

					<form method="POST" action="{{ route('bank-accounts.destroy', $account->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						<div class="card mb-3">

							@component('partials.card-header')
								Delete Bank Account
							@endcomponent

							<div class="card-body">

								<p class="card-text">
									You can delete this bank account and prevent it form being used in the future.
								</p>

							</div>
							<div class="card-footer">
								@component('partials.save-button')
									Delete Bank Account
								@endcomponent
							</div>

						</div>

					</form>

				@endif

			</div>
		</div>

	@endcomponent

@endsection