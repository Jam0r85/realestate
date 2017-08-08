@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('properties.show', $property->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $property->name }}</h1>
			<h2 class="subtitle">Edit Details</h2>

		</div>
	</section>

	<section class="section">
		<div class="container">

			<form role="form" method="POST" action="{{ route('properties.update', $property->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				@include('partials.errors-block')

				@include('properties.partials.form')

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Save Changes
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection