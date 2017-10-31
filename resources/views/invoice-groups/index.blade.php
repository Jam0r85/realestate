@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('invoice-groups.create') }}" class="btn btn-primary float-right">
				<i class="fa fa-plus"></i> New Invoice Group
			</a>

			@component('partials.header')
				Invoice Groups List
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<table class="table table-striped table-hover table-responsive">
			<thead>
				<th>Name</th>
				<th>Next Number</th>
				<th>Unpaid</th>
				<th>Format</th>
			</thead>
			<tbody>
				@foreach ($invoice_groups as $group)
					<tr>
						<td>
							<a href="{{ route('invoice-groups.show', $group->id) }}" title="{{ $group->name}} ">
								{{ $group->name }}
							</a>
						</td>
						<td>{{ $group->next_number }}</td>
						<td>{{ count($group->unpaidInvoices) }}</td>
						<td>{{ $group->format }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

	@endcomponent

@endsection