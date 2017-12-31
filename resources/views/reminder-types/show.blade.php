@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="mb-2 text-right">
			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="reminderTypeOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					@icon('options') Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="reminderTypeOptionsDropdown">
					<a class="dropdown-item" href="{{ route('reminder-types.edit', $type->id) }}">
						@icon('edit') Edit Reminder Type
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			{{ $type->name }}
		@endcomponent

		@component('partials.sub-header')
			{{ $type->description }}
		@endcomponent
		
	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<ul class="nav nav-pills">
			<li class="nav-item">
				{!! Menu::showLink('Details', 'reminder-types.show', $type->id, 'index') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Reminders', 'reminder-types.show', $type->id) !!}
			</li>
		</ul>

		@include('reminder-types.show.' . $show)

	@endcomponent

@endsection