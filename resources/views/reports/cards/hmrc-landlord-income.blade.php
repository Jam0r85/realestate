<div class="card mb-3">

	@component('partials.card-header')
		HMRC Landlord Income
	@endcomponent

	<div class="card-body">

		<form method="POST" action="{{ route('reports.hmrc-landlords-income') }}">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="from">From</label>
				<input type="date" class="form-control" name="from" value="{{ old('from') }}" />
			</div>

			<div class="form-group">
				<label for="until">Until</label>
				<input type="date" class="form-control" name="until" value="{{ old('until') }}" />
			</div>

			@component('partials.save-button')
				Generate
			@endcomponent

		</form>

	</div>
</div>