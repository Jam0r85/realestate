@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			@component('partials.header')
				Create Property
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('properties.store') }}">
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

			@component('partials.save-button')
				Create Property
			@endcomponent

		</form>

	@endcomponent

@endsection