@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>New Branch</h1>
			</div>

			@include('partials.errors-block')

			<form role="form" action="{{ route('branches.store') }}" method="POST">
				{{ csrf_field() }}

				@include('branches.partials.form')

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Create Branch
				</button>

			</form>

		</div>
	</section>

@endsection