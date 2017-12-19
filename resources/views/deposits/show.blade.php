@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="depositOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-cogs"></i> Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="depositOptionsDropdown">
					<a class="dropdown-item" href="{{ route('deposit.edit', $deposit->id) }}">
						<i class="fa fa-edit"></i> Edit Deposit
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			Deposit #{{ $deposit->id }}
		@endcomponent

		@component('partials.sub-header')
			{{ $deposit->tenancy->present()->name }}
		@endcomponent
		
	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<ul class="nav nav-pills">
			<li class="nav-item">
				{!! Menu::showLink('Details', 'deposit.show', $deposit->id, 'index') !!}
			</li>
		</ul>

		@include('deposits.show.' . $show)

	@endcomponent

@endsection