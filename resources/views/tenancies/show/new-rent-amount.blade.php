@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('tenancies.show', $tenancy->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $tenancy->name }}</h1>
			<h2 class="subtitle">New rent amount</h2>

			<hr />

			<form role="form" method="POST" action="{{ route('tenancies.create-rent-amount', $tenancy->id) }}">
				{{ csrf_field() }}

				<div class="field">
					<label class="label" for="starts_at">Start Date</label>
					<div class="control">
						<input type="date" class="input" name="starts_at" value="{{ old('starts_at') }}">
					</div>
				</div>

				<div class="field">
					<label class="label" for="amount">Rent Amount</label>
					<div class="control">
						<input type="number" step="any" class="input" name="amount" value="{{ old('amount') }}">
					</div>
				</div>

				<div class="field">
					<label class="checkbox">
						<input type="checkbox" name="create_agreement" id="createAgreementCheckbox" value="true" />
						Create a new Agreement at the same time?
					</label>
				</div>

				<div class="field is-hidden" id="agreementLength">
					<label class="label" for="length">Agreement Length</label>
					<div class="control">
						<span class="select is-fullwidth">
							<select name="length">
								<option value="3-months">3 Months</option>
								<option value="6-months">6 Months</option>
								<option value="12-months">12 Months</option>
							</select>
						</span>
					</div>
				</div>

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Create Rent Amount
					</span>
				</button>

			</form>


		</div>
	</section>

@endsection

@push('footer_scripts')
<script>
	$('#createAgreementCheckbox').change(function () {
		if ($(this).prop('checked')) {
			$('#agreementLength').removeClass('is-hidden');
		} else {
			$('#agreementLength').addClass('is-hidden');
		}
	});
</script>
@endpush