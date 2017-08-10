@extends('tenancies.show.layout')

@section('sub-content')

	<form role="form" method="POST" action="{{ route('tenancies.create-old-rental-statement', $tenancy->id) }}">
		{{ csrf_field() }}

		@component('partials.sections.section-no-container')

			@component('partials.title')
				Record Old Statement
			@endcomponent

			<div class="field">
				<label class="label" for="created_at">Date Created</label>
				<div class="control">
					<input type="date" name="created_at" class="input" />
				</div>
			</div>

			<div class="field">
				<label class="label" for="period_start">Start Date</label>
				<div class="control">
					<input type="date" name="period_start" class="input" />
				</div>
			</div>

			<div class="field">
				<label class="label" for="period_end">End Date</label>
				<div class="control">
					<input type="date" name="period_end" class="input" />
				</div>
			</div>

			<div class="field">
				<label class="label" for="amount">Statement Amount</label>
				<div class="control">
					<input type="number" step="any" name="amount" class="input" />
				</div>
			</div>

			<div class="field">
				<label class="label" for="payment_method_id">Payment Method</label>
				<div class="control">
					<span class="select is-fullwidth">
						<select name="payment_method_id">
							@foreach (payment_methods() as $method)
								<option value="{{ $method->id }}">{{ $method->name }}</option>
							@endforeach
						</select>
					</span>
				</div>
			</div>

			<div class="field">
				<label class="label" for="rent_received">Rent Received <small>(if different from statement amount)</small></label>
				<div class="control">
					<input type="number" step="any" name="rent_received" class="input" />
				</div>
			</div>

		@endcomponent

		@component('partials.sections.section-no-container')

			@component('partials.subtitle')
				Add Invoice Items
			@endcomponent

			<div class="field">
				<label class="label" for="invoice_number">Invoice Number</label>
				<div class="control">
					<input type="number" step="any" name="invoice_number" class="input" />
				</div>
			</div>

			<div class="columns">
				<div class="column">
					<div class="card">
						<header class="card-header">
							<p class="card-header-title">
								Item #1
							</p>
						</header>
						<div class="card-content">

							<div class="field">
								<label class="label" for="item_name">Name</label>
								<div class="control">
									<input type="text" name="item_name[]" class="input" />
								</div>
							</div>

							<div class="field">
								<label class="label" for="item_description">Description</label>
								<div class="control">
									<textarea name="item_description[]" class="textarea"></textarea>
								</div>
							</div>

							<div class="field">
								<label class="label" for="item_quantity">Quantity</label>
								<div class="control">
									<input type="number" step="any" name="item_quantity[]" class="input" value="1" />
								</div>
							</div>

							<div class="field">
								<label class="label" for="item_amount">Amount</label>
								<div class="control">
									<input type="number" step="any" name="item_amount[]" class="input" />
								</div>
							</div>

							<div class="field">
								<label class="label" for="item_tax_rate_id">Tax</label>
								<div class="control">
									<span class="select is-fullwidth">
										<select name="item_tax_rate_id[]">
											<option selected value="0">None</option>
											@foreach (tax_rates() as $rate)
												<option value="{{ $rate->id }}">{{ $rate->name }}</option>
											@endforeach
										</select>
									</span>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="column">
					<div class="card">
						<header class="card-header">
							<p class="card-header-title">
								Item #2
							</p>
						</header>
						<div class="card-content">

							<div class="field">
								<label class="label" for="itemn_name">Name</label>
								<div class="control">
									<input type="text" name="item_name[]" class="input" />
								</div>
							</div>

							<div class="field">
								<label class="label" for="item_description">Description</label>
								<div class="control">
									<textarea name="item_description[]" class="textarea"></textarea>
								</div>
							</div>

							<div class="field">
								<label class="label" for="item_quantity">Quantity</label>
								<div class="control">
									<input type="number" step="any" name="item_quantity[]" class="input" value="1" />
								</div>
							</div>

							<div class="field">
								<label class="label" for="item_amount">Amount</label>
								<div class="control">
									<input type="number" step="any" name="item_amount[]" class="input" />
								</div>
							</div>

							<div class="field">
								<label class="label" for="item_tax_rate_id">Tax</label>
								<div class="control">
									<span class="select is-fullwidth">
										<select name="item_tax_rate_id[]">
											<option selected value="0">None</option>
											@foreach (tax_rates() as $rate)
												<option value="{{ $rate->id }}">{{ $rate->name }}</option>
											@endforeach
										</select>
									</span>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

		@endcomponent

		@component('partials.sections.section-no-container')

			<button type="submit" class="button is-primary is-outlined">
				Create Statement
			</button>

		@endcomponent

	</form>

@endsection