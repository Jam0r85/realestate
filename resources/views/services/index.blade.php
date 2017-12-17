@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			<a href="{{ route('services.create') }}" class="btn btn-primary">
				<i class="fa fa-plus"></i> New Service
			</a>
		</div>

		@component('partials.header')
			Services
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@component('partials.table')
			@slot('header')
				<th>Name</th>
				<th>Letting Fee</th>
				<th>Re-Letting Fee</th>
				<th>Management</th>
				<th>Tax</th>
				<th></th>
			@endslot
			@slot('body')
				@foreach ($services as $service)
					<tr>
						<td>{{ $service->name }}<br />{{ $service->description }}</td>
						<td>{{ currency($service->letting_fee) }}</td>
						<td>{{ currency($service->re_letting_fee) }}</td>
						<td>{{ $service->present()->serviceChargeFormatted }}</td>
						<td>{{ $service->taxRate ? $service->taxRate->name : '-' }}</td>
						<td>
							<a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning btn-sm">
								Edit
							</a>
						</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

	@endcomponent

@endsection