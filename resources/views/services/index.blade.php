@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('services.create') }}" class="btn btn-primary">
				<i class="fa fa-plus"></i> New Service
			</a>

			@component('partials.header')
				Services
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@component('partials.table')
			@slot('header')
				<th>Name</th>
				<th>Letting Fee</th>
				<th>Re-Letting Fee</th>
				<th>Management</th>
				<th>Tax</th>
			@endslot
			@slot('body')
				@foreach ($services as $service)
					<tr>
						<td>
							<a href="{{ route('services.edit', $service->id) }}" title="{{ $service->name }}">
								{{ $service->name }}
							</a>
							<br /><small>{{ $service->description }}</small>
						</td>
						<td>{{ currency($service->letting_fee) }}</td>
						<td>{{ currency($service->re_letting_fee) }}</td>
						<td>
							@include('services.format.service-charge')
						</td>
						<td>{{ $service->taxRate ? $service->taxRate->name : '-' }}</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

	@endcomponent

@endsection