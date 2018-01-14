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
				<a class="nav-link @if (!Request::segment(3)) active @endif" href="{{ route('invoice-groups.show', $group->id) }}">
					Details
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (Request::segment(3) == 'unpaid-invoices') active @endif" href="{{ route('invoice-groups.show', [$group->id, 'unpaid-invoices']) }}">
					Unpaid Invoices
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (Request::segment(3) == 'paid-invoices') active @endif" href="{{ route('invoice-groups.show', [$group->id, 'paid-invoices']) }}">
					Paid Invoices
				</a>
			</li>
		</ul>

		@include('invoice-groups.show.' . $show)

	@endcomponent

@endsection