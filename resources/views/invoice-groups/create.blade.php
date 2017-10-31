@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			@component('partials.header')
				New Invoice Group
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('invoice-groups.store') }}">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="branch_id">Branch</label>
				<select class="form-control" name="branch_id">
					@foreach(branches() as $branch)
						<option value="{{ $branch->id }}">{{ $branch->name }}</option>
					@endforeach
				</select>
			</div>

			@include('invoice-groups.partials.form')

			<button type="submit" class="btn btn-primary">
				<i class="fa fa-save"></i> Create Invoice Group
			</button>

		</form>

	@endcomponent

@endsection