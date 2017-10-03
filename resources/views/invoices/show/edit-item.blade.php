@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('invoices.show', $item->invoice->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>Invoice #{{ $item->invoice->number }}</h1>
				<h3>Edit invoice item</h3>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('partials.errors-block')

			<div class="card mb-3 border-primary">
				<div class="card-header bg-primary text-white">
					Item Details
				</div>
				<div class="card-body">

					<form role="form" method="POST" action="{{ route('invoices.update-item', $item->id) }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}

						@include('invoices.partials.item-form')

						<button type="submit" class="btn btn-danger float-right" name="remove_item" value="true">
							<i class="fa fa-trash"></i> Remove Item
						</button>

						@component('partials.bootstrap.save-submit-button')
							Save Changes
						@endcomponent

					</form>

				</div>
			</div>

		</div>
	</section>

@endsection