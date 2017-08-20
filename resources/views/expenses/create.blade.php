@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">Create Expense</h1>

			<hr />

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
				{{ csrf_field() }}

				<div class="field">
					<label class="label" for="property_id">Property</label>
					<div class="control">
						<select name="property_id" class="select2">
							<option value="">Please select..</option>
							@foreach(properties() as $property)
								<option value="{{ $property->id }}">{{ $property->select_name }}</option>
							@endforeach
						</select>
					</div>
				</div>

				@include('expenses.partials.form')

				<div class="field">
					<label class="label" for="files">Invoice(s)</label>
					<div class="control">
						<input type="file" class="input" name="files[]" multiple />
					</div>
				</div>

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Create Expense
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection