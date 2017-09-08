@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					New Invoice Group
				</h1>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('invoice-groups.store') }}">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="branch_id">Branch</label>
					<select class="form-control" name="branch_id">
						@foreach(branches() as $branch)
							<option value="{{ $branch->id }}">{{ $branch->name }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="name">Name</label>
					<input class="form-control" type="text" name="name" value="{{ old('name') }}" />
				</div>

				<div class="form-group">
					<label for="format">Name Format</label>
					<input class="form-control" type="text" name="format" value="{{ old('format') }}" />
					<small class="form-text text-muted">
						Use [[number]] to postion the invoice number.
					</small>
				</div>

				<div class="form-group">
					<label for="next_number">Starting Number</label>
					<input class="form-control" type="number" name="next_number" value="{{ old('next_number') }}" />
					<small class="form-text text-muted">
						Enter the starting invoice group number.
					</small>
				</div>

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Create Invoice Group
				</button>

			</form>

		</div>
	</section>

@endsection