@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('properties.index') }}">Properties List</a></li>
	<li class="is-active"><a>{{ $property->name }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $property->name }}
		@endslot
	@endcomponent

@endsection