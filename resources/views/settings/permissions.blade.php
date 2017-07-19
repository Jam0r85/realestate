@extends('settings.template')

@section('sub-content')

	@component('partials.sections.section')
		@slot('title')
			Permissions
		@endslot

		<div class="content">
			<p>
				List of avaliable permissions which can be assigned to the different branch roles.
			</p>
		</div>

		@if (can('read-permission'))
			<table class="table is-striped is-bordered">
				<thead>
					<th>Name</th>
					<th>Slug</th>
					<th>Description</th>
				</thead>
				<tbody>
					@foreach ($permissions as $permission)
						<tr>
							<td>{{ $permission->name }}</td>
							<td>{{ $permission->slug }}</td>
							<td>{{ $permission->description }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endif

	@endcomponent

@endsection