@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="invoiceGroupOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-cogs"></i> Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="invoiceGroupOptionsDropdown">
					<a class="dropdown-item" href="{{ route('invoice-groups.edit', $group->id) }}">
						<i class="fa fa-edit"></i> Edit Group
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			{{ $group->name }}
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<ul class="nav nav-pills">
			<li class="nav-item">
				{!! Menu::showLink('Details', 'invoice-groups.show', $group->id, 'index') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Unpaid Invoices', 'invoice-groups.show', $group->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Paid Invoices', 'invoice-groups.show', $group->id) !!}
			</li>
		</ul>

		@include('invoice-groups.show.' . $show)

	@endcomponent

@endsection