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
				<th>Options</th>
			@endslot
			@foreach ($groups as $user_group)
				<tr>
					<td><a href="{{ route('user-groups.show', $user_group->id) }}">{{ $user_group->name }}</a></td>
					<td>
						<a href="{{ route('user-groups.edit', $user_group->id) }}" class="button is-small is-warning">
							<span class="icon is-small">
								<i class="fa fa-edit"></i>
							</span>
							<span>
								Edit
							</span>
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
			@slot('saveButton')
				Create User Group
			@endslot

				@include('partials.errors-block')

				@include('user-groups.partials.form')

		@endcomponent

	</form>

@endsection