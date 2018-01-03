@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="mb-2 text-right">
			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="roleOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					@icon('options') Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="roleOptionsDropdown">
					<a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}">
						@icon('edit') Edit Role
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			{{ $role->name }}
		@endcomponent

		@component('partials.sub-header')
			{{ $role->branch->name }}
		@endcomponent
		
	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<ul class="nav nav-pills">
			<li class="nav-item">
				{!! Menu::showLink('Details', 'roles.show', $role->id, 'index') !!}
			</li>
		</ul>

		@include('roles.show.' . $show)

	@endcomponent

@endsection