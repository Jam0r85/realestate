@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Tenancy
				@slot('url')
					{{ route('tenancies.show', $tenancy->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Record Old Statement
		@endcomponent

		@component('partials.sub-header')
			{{ $tenancy->present()->name }}
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('old-statements.store', $tenancy->id) }}">
			{{ csrf_field() }}

			<div class="row">
				<div class="col-12 col-lg-8">

					<div class="card mb-3">
						@component('partials.card-header')
							Statement Details
						@endcomponent
						<div class="card-body">

							<div class="form-group">
								<label for="created_at">Date Created</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="date" name="created_at" id="created_at" class="form-control" value="{{ old('created_at') }}" />
								</div>
							</div>

							<div class="form-group">
								<label for="period_start">Date Start</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="date" name="period_start" id="period_start" class="form-control" value="{{ old('period_start') }}" />
								</div>
							</div>

							<div class="form-group">
								<label for="period_end">Date End</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="date" name="period_end" id="period_end" class="form-control" value="{{ old('period_end') }}" />
								</div>
							</div>

							<div class="form-group">
								<label for="amount">Amount</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-money-bill"></i>
									</span>
									<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" />
								</div>
							</div>

							<div class="form-group">
								<label for="users">Users</label>
								<select name="users[]" id="users" class="form-control select2" multiple>
									@foreach (users() as $user)
										<option @if ($tenancy->property->owners->contains($user->id)) selected @endif value="{{ $user->id }}">
											{{ $user->present()->selectName }}
										</option>
									@endforeach
								</select>
							</div>

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</div>
					</div>

				</div>
				<div class="col-12 col-lg-4">


				</div>
			</div>

		</form>

	@endcomponent

@endsection