@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Create branch
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<form action="{{ route('branches.store') }}" method="POST">
			{{ csrf_field() }}

			@component('partials.card')

				<div class="card-body">

					@include('branches.partials.form')

				</div>

				@slot('footer')
					@component('partials.save-button')
						Create Branch
					@endcomponent
				@endslot

			@endcomponent

		</form>

	@endcomponent

@endsection