@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			<a href="{{ route('appearances.create') }}" class="btn btn-primary">
				<i class="fa fa-plus"></i> New Appearance
			</a>
		</div>

		@component('partials.header')
			{{ isset($title) ? $title : 'Appearances List' }}
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('appearances.partials.appearances-table')
		@include('partials.pagination', ['collection' => $appearances])

	@endcomponent

@endsection