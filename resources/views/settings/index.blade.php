@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Settings
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<ul class="nav nav-pills">
			<li class="nav-item">
				<a href="{{ route('settings.index') }}" class="nav-link @if (!Request::segment(2)) active @endif">
					General
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('settings.index', 'company') }}" class="nav-link @if (Request::segment(2) == 'company') active @endif">
					Company
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('settings.index', 'invoices') }}" class="nav-link @if (Request::segment(2) == 'invoices') active @endif">
					Invoices
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('settings.index', 'reminder-types') }}" class="nav-link @if (Request::segment(2) == 'reminder-types') active @endif">
					Reminder Types
				</a>
			</li>
		</ul>

		@include('settings.show.' . $show)

	@endcomponent

@endsection