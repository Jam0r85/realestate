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
				<a href="{{ route('settings.index', 'invoices') }}" class="nav-link @if (Request::segment(2) == 'invoices') active @endif">
					Invoices
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('settings.index', 'reminders') }}" class="nav-link @if (Request::segment(2) == 'reminders') active @endif">
					Reminders
				</a>
			</li>
		</ul>

		@include('settings.show.' . $show)

	@endcomponent

@endsection