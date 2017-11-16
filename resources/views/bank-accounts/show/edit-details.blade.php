@extends('layouts.app')

@section('content')

	@component('partials.page-header')
	
		<a href="{{ route('bank-accounts.show', $account->id) }}" class="btn btn-secondary float-right">
			Return
		</a>

		@component('partials.header')
			{{ $account->account_name }}
		@endcomponent

		@component('partials.sub-header')
			Edit Account Details
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@component('partials.alerts.info')
			<i class="fa fa-info-circle"></i> <b>Important Note</b><br />When a landlord is changing their bank account it is better to archive their original account and create a new one as opposed to updating the account number and sort code.
		@endcomponent

		@include('partials.errors-block')

		<div class="row">
			<div class="col-sm-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Bank Account Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('bank-accounts.update', $account->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							@include('bank-accounts.partials.form')

							<div class="form-group">
								<label for="users">Attached Users</label>
								<select name="users[]" id="users" class="form-control select2" multiple>
									@foreach (users() as $user)
										<option @if ($account->users->contains($user->id)) selected @endif value="{{ $user->id }}">
											{{ $user->present()->selectName }}
										</option>
									@endforeach
								</select>
							</div>

							@component('partials.save-button')
								Save Changes
								@if ($account->trashed())
									@slot('disabled')
										You cannot edit an archived account
									@endslot
								@endif
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-sm-12 col-lg-6">

				@if ($account->trashed())

					<div class="card mb-3">

						@component('partials.card-header')
							Restore Bank Account
						@endcomponent

						<div class="card-body">

							<form method="POST" action="{{ route('bank-accounts.restore', $account->id) }}">
								{{ csrf_field() }}
								{{ method_field('PUT') }}

								<p class="card-text">
									You can restore this bank account by entering it's ID into the field below.
								</p>

								<div class="form-group">
									<input type="number" step="any" class="form-control" name="confirmation" />
								</div>

								@component('partials.save-button')
									Restore Bank Account
								@endcomponent

							</form>

						</div>

					</div>

				@else

					<div class="card mb-3">

						@component('partials.card-header')
							Archive Bank Account
						@endcomponent

						<div class="card-body">

							<form method="POST" action="{{ route('bank-accounts.destroy', $account->id) }}">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}

								<p class="card-text">
									You can archive this bank account and prevent it from being used in the future by entering it's ID into the field below.
								</p>

								<div class="form-group">
									<input type="number" step="any" class="form-control" name="confirmation" />
								</div>

								@component('partials.save-button')
									Archive Bank Account
								@endcomponent

							</form>

						</div>

					</div>

				@endif

			</div>
		</div>

	@endcomponent

@endsection