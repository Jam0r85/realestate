@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="mb-2 text-right">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#quickNoteModal">
				@icon('sms') Quick Note
			</button>

			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="issueOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					@icon('options') Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="issueOptionsDropdown">
					<a class="dropdown-item" href="{{ route('maintenances.edit', $issue->id) }}">
						@icon('edit') Edit Issue
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			{{ $issue->name }}
		@endcomponent

		@component('partials.sub-header')
			{{ $issue->property->present()->fullAddress }}
		@endcomponent
		
	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<ul class="nav nav-pills">
			<li class="nav-item">
				<a class="nav-link @if (!Request::segment('3')) active @endif" href="{{ route('maintenances.show', $issue->id) }}">
					Details
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (Request::segment('3') == 'notes') active @endif" href="{{ route('maintenances.show', [$issue->id, 'notes']) }}">
					Notes
					<span class="badge badge-secondary">
						{{ count($issue->notes) }}
					</span>
				</a>
			</li>
		</ul>

		@include('maintenances.show.' . $show)

	@endcomponent

	@include('notes.modals.quick-note-modal', [
		'route' => route('maintenances.store-note', $issue->id)
	])

@endsection