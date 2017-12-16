@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Settings
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		<ul class="nav nav-pills">
			<li class="nav-item">
				<a href="{{ route('settings.index') }}" class="nav-link">
					General
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('settings.index', 'invoices') }}" class="nav-link">
					Invoices
				</a>
			</li>
		</ul>

		@include('settings.show.' . $show)

	@endcomponent

@endsection