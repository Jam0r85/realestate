<div class="card mb-3">

	@component('partials.card-header')
		Landlord Tax Report
	@endcomponent

	<div class="card-body">

		<form method="POST" action="{{ route('reports.landlord-tax-report') }}">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="from">Start Date</label>
				<input type="date" class="form-control" name="from" id="from" value="{{ old('from') }}" />
			</div>

			<div class="form-group">
				<label for="until">End Date</label>
				<input type="date" class="form-control" name="until" id="until" value="{{ old('until') }}" />
			</div>

			<div class="form-group">
				<label for="tenancy_id">Tenancy</label>
				<select name="tenancy_id" id="tenancy_id" class="form-control">
					@foreach (tenancies() as $tenancy)
						<option value="{{ $tenancy->id }}">
							{!! $tenancy->present()->selectName !!}
						</option>
					@endforeach
				</select>
			</div>

			@component('partials.save-button')
				Create Report
			@endcomponent

		</form>

	</div>
</div>