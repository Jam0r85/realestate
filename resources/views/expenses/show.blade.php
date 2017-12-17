@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="expenseOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="expenseOptionsDropdown">
					<a class="dropdown-item" href="{{ route('expenses.edit', $expense->id) }}">
						<i class="fa fa-edit"></i> Edit Expense
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			{{ $expense->name }}
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@if ($expense->isPaid())
			@component('partials.alerts.success')
				This expense was paid {{ date_formatted($expense->paid_at) }}
			@endcomponent
		@endif

		<ul class="nav nav-pills">
			<li class="nav-item">
				{!! Menu::showLink('Details', 'expenses.show', $expense->id, 'index') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Invoices', 'expenses.show', $expense->id, 'invoices') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Payments', 'expenses.show', $expense->id, 'payments') !!}
			</li>
		</ul>

		@include('expenses.show.' . $show)

	@endcomponent

@endsection