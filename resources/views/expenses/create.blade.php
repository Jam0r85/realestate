@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Create Expense
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3">
			@component('partials.card-header')
				Create Expense
			@endcomponent

			<div class="card-body">

				<form method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="property_id">Property</label>
						<select name="property_id" id="property_id" class="form-control select2">
							<option value="">Please select..</option>
							@foreach(properties() as $property)
								<option @if (old('property_id') == $property->id) selected @endif value="{{ $property->id }}">
									{{ $property->present()->selectName }}
								</option>
							@endforeach
						</select>
						<small class="form-text text-muted">
							Please select the property that this expense is for.
						</small>
					</div>

					<div class="form-group">
						<label for="name">Expense Name</label>
						<input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" />
						<small class="form-text text-muted">
							Enter a name for this expense. This will appear on the rental statement.
						</small>
					</div>

					<div class="form-group">
						<label for="cost">Expense Cost</label>
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-money-bill"></i>
							</span>
							<input class="form-control" type="number" step="any" name="cost" id="cost" value="{{ old('cost') }}" />
						</div>
						<small class="form-text text-muted">
							Enter the full cost of the expense.
						</small>
					</div>

					<div class="form-group">
						<label for="contractor_id">Contractor</label>
						<select name="contractor_id" id="contractor_id" class="form-control select2">
							<option value="">None</option>
							@foreach (users() as $user)
								<option @if (old('contractor_id') == $user->id)) selected @endif value="{{ $user->id }}">
									{{ $user->present()->fullName }}
								</option>
							@endforeach
						</select>
						<small class="form-text text-muted">
							Select the contractors to be attached to this expense.
						</small>
					</div>

					<div class="form-group">
						<label for="contractor_reference">Invoice Number (optional)</label>
						<input class="form-control" type="text" name="contractor_reference" id="contractor_reference" value="{{ old('contractor_reference') }}" />
						<small class="form-text text-muted">
							Enter the invoice or reference number for this expense received from the contractor.
						</small>
					</div>

					<div class="form-group">
						<label for="files">Upload Invoice(s)</label>
						<input type="file" id="files" class="form-control-file" name="files[]" multiple />
					</div>

					@component('partials.save-button')
						Create Expense
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection