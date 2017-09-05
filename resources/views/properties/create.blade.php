@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>New Property</h1>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('properties.store') }}">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="branch_id">Branch</label>
					<select name="branch_id" class="form-control">
						@foreach (branches() as $branch)
							<option value="{{ $branch->id }}">{{ $branch->name }}</option>
						@endforeach
					</select>
				</div>

				@include('properties.partials.form')

				<div class="form-group">
					<label for="owners">Owners</label>
					<select name="owners[]" class="form-control select2" multiple>
						@foreach (users() as $user)
							<option value="{{ $user->id }}">{{ $user->name }}</option>
						@endforeach
					</select>
				</div>

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Create Property
				</button>

			</form>

		</div>
	</section>

@endsection