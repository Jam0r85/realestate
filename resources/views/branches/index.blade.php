@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			<a href="{{ route('branches.create') }}" class="btn btn-primary">
				@icon('plus') Register Branch
			</a>
		</div>

		@component('partials.header')
			Branches
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('branches.partials.table')

	@endcomponent

@endsection