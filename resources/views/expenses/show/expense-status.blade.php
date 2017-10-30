@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				{{ $expense->name }}
			@endcomponent

			@component('partials.sub-header')
				Change expense status
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3">

			@component('partials.card-header')
				Delete Expense
				@slot('small')
					Delete this expense and it's related documents from the system.
				@endslot
			@endcomponent

			<div class="card-body">

				<form method="POST" action="{{ route('expenses.destroy', $expense->id) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					<p class="card-text">
						Please enter the name of this expense into the field below to confirm that you wish to delete this expense.
					</p>

					<div class="form-group">
						<input type="text" name="confirmation" id="confirmation" class="form-control" />
					</div>

					<button type="submit" class="btn btn-danger">
						<i class="fa fa-trash"></i> Delete Expense
					</button>

				</form>

			</div>

		</div>

	@endcomponent

@endsection