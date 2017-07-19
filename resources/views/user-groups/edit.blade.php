@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('settings.index') }}">Settings</a></li>
	<li><a href="{{ route('settings.user-groups') }}">User Groups</a></li>
	<li><a href="{{ route('user-groups.show', $group->slug) }}">{{ $group->name }}</a></li>
	<li class="is-active"><a>Edit</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $group->name }}
		@endslot
	@endcomponent

	<form role="form" method="POST" action="{{ route('user-groups.update', $group->id) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}

		@component('partials.sections.section')
			@slot('saveButton')
				Save Changes
			@endslot

			@include('user-groups.partials.form')

		@endcomponent

	</form>

@endsection