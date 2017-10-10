@extends('settings.layout')

@section('settings-content')

	@include('partials.errors-block')

	<form role="form" method="POST" action="{{ route('settings.update-tax-rate', $rate->id) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}

		<div class="form-group">
			<label for="name">Rate Name</label>
			<input type="text" name="name" class="form-control" value="{{ $rate->name }}" required />
		</div>

		@component('partials.bootstrap.save-submit-button')
			Update Tax Rate
		@endcomponent

	</form>

	@if ($rate->trashed())

		<form role="form" method="POST" action="{{ route('settings.restore-tax-rate', $rate->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="card border-info mt-3">
				<div class="card-body">
					<h4 class="card-title">
						Restore "{{ $rate->name }}"
					</h4>

					<p class="card-text">
						You can restore this tax rate and allow it to be used again. Enter the name of the tax rate below to confirm that you wish to restore it.
					</p>

					<div class="form-group">
						<input type="text" name="confirmation" class="form-control" required />
					</div>

					<button type="submit" class="btn btn-info">
						<i class="fa fa-history"></i> Restore Tax Rate
					</button>

				</div>
			</div>

		</form>

	@else

		<form role="form" method="POST" action="{{ route('settings.destroy-tax-rate', $rate->id) }}">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}

			<div class="card border-danger mt-3">
				<div class="card-body">
					<h4 class="card-title">
						Delete "{{ $rate->name }}"
					</h4>

					<p class="card-text">
						You cannot edit a tax rate as the invoice amounts which were calculated before would become incorrect. You can however delete a tax rate which will preserve the amounts but will prevent it from being used in the future.
					</p>

					<p class="card-text">
						To confirm that you wish to delete this rate, please enter the name of the rate ({{ $rate->name }}) into the field below.
					</p>

					<div class="form-group">
						<input type="text" name="confirmation" class="form-control" required />
					</div>

					<button type="submit" class="btn btn-danger">
						<i class="fa fa-trash"></i> Delete Tax Rate
					</button>

				</div>
			</div>

		</form>

	@endif

@endsection