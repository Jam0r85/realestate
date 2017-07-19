@extends('settings.template')

@section('breadcrumbs')
	<li><a href="{{ route('settings.index') }}">Settings</a></li>
	<li class="is-active"><a>User Groups</a></li>
@endsection

@section('sub-content')

	@component('partials.sections.section-no-container')
		@slot('title')
			User Groups
		@endslot

		@component('partials.table')
			@slot('head')
				<th>Name</th>
				<th>Actions</th>
			@endslot
			@foreach ($groups as $user_group)
				<tr>
					<td><a href="{{ route('user-groups.show', $user_group->id) }}">{{ $user_group->name }}</a></td>
					<td class="has-text-right">
						<a href="{{ route('user-groups.edit', $user_group->id) }}">
							Edit Group
						</a>
					</td>
				</tr>
			@endforeach
		@endcomponent


	@endcomponent

	<form role="form" method="POST" action="{{ route('user-groups.store') }}">
		{{ csrf_field() }}

		@component('partials.sections.section-no-container')
			@slot('title')
				Create User Group
			@endslot

			@include('partials.errors-block')

			@include('user-groups.partials.form')

			<button type="submit" class="button is-primary is-outlined">
				Create Group
			</button>

		@endcomponent

	</form>

@endsection