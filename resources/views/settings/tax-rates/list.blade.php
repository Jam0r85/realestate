@extends('settings.layout')

@section('settings-content')

	<table class="table table-striped table-hover table-responsive mb-3">
		<thead>
			<th>Name</th>
			<th class="text-right">Amount</th>
		</thead>
		<tbody>
			@foreach ($rates as $rate)
				<tr>
					<td>
						@if ($rate->trashed())
							<span class="text-muted">
								<i class="fa fa-archive"></i>
							</span>
						@endif
						<a href="{{ route('settings.edit-tax-rate', $rate->id) }}" title="{{ $rate->name }}">
							{{ $rate->name }}
						</a>
					</td>
					<td class="text-right">{{ $rate->amount }}%</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<div class="card border-primary">
		<div class="card-header bg-primary text-white">
			New Tax Rate
		</div>
		<div class="card-body">

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('settings.store-tax-rate') }}">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="name">Rate Name</label>
					<input type="text" name="name" class="form-control" value="{{ old('name') }}" required />
				</div>

				<div class="form-group">
					<label for="amount">Rate Amount (in %)</label>
					<input type="number" step="any" name="amount" class="form-control" value="{{ old('amount') }}" required />
				</div>

				@component('partials.bootstrap.save-submit-button')
					Create Tax Rate
				@endcomponent

			</form>

		</div>
	</div>

@endsection