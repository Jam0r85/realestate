@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('properties.show', $property->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $property->short_name }}</h1>
				<h2>Edit Details</h2>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('properties.update', $property->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}				

				@include('properties.partials.form')

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Save Changes
				</button>

			</form>

		</div>
	</section>

@endsection