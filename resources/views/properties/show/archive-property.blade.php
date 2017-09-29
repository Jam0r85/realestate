@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('properties.show', $property->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $property->short_name }}</h1>
				<h2>Archive this property</h2>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			@if ($property->trashed())

				<div class="alert alert-danger">
					<b>This property has already been archived.</b> Would you like to restore it?
				</div>

			@else

				<form role="form" method="POST" action="{{ route('properties.archive', $property->id) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					<button type="submit" class="btn btn-danger">
						<i class="fa fa-archive"></i> Archive Property
					</button>

				</form>

			@endif

		</div>
	</section>

@endsection