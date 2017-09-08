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

				@include('invoice-groups.partials.form')

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Create Invoice Group
				</button>

			</form>

		</div>
	</section>

@endsection