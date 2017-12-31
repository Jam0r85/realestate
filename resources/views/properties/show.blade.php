@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="propertyOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-cogs"></i> Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="propertyOptionsDropdown">
					<a class="dropdown-item" href="{{ route('properties.edit', $property->id) }}">
						<i class="fa fa-edit"></i> Edit Property
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			{{ $property->present()->shortAddress }}
		@endcomponent
		
	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<ul class="nav nav-pills">
			<li class="nav-item">
				{!! Menu::showLink('Details', 'properties.show', $property->id, 'index') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Tenancies', 'properties.show', $property->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Invoices', 'properties.show', $property->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Statements', 'properties.show', $property->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Expenses', 'properties.show', $property->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Reminders', 'properties.show', $property->id) !!}
			</li>
		</ul>

		@include('properties.show.' . $show)

	@endcomponent

@endsection