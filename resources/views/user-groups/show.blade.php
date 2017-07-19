@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('users.index') }}">Users</a></li>
	<li><a href="{{ route('user-groups.index') }}">Groups</a></li>
	<li class="is-active"><a>{{ $group->name }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $group->name }}
		@endslot
	@endcomponent

	@component('partials.sections.section')

		<div class="container">

			@include('users.partials.table', ['users' => $group->users])

		</div>

	@endcomponent

@endsection