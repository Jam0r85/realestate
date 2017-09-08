@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('branches.show', $branch->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $branch->name }}</h1>
				<h3>Edit branch details</h3>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('branches.update', $branch->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}			

				@include('branches.partials.form')

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Save Changes
				</button>

			</form>

		</div>
	</section>

@endsection