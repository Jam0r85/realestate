@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('tenancies.index') }}">Tenancies List</a></li>
	<li class="is-active"><a>New Tenancy</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			New Tenancy
		@endslot
	@endcomponent

@endsection