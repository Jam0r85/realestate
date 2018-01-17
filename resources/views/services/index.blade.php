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
				<th>Status</th>
				<th>Name</th>
				<th>Letting Fee</th>
				<th>Re-Letting Fee</th>
				<th>Management</th>
				<th>Tax</th>
			@endslot
			@slot('body')
				@foreach ($services as $service)
					<tr class="clickable-row" data-href="{{ route('services.edit', $service->id) }}" data-toggle="tooltip" data-placement="left" title="Edit {{ $service->name }}">
						<td>{{ $service->present()->statusLabel }}</td>
						<td>{{ $service->name }}<br />{{ $service->description }}</td>
						<td>{{ $service->present()->money('letting_fee') }}</td>
						<td>{{ $service->present()->money('re_letting_fee') }}</td>
						<td>{{ $service->present()->serviceChargeFormatted }}</td>
						<td>{{ $service->present()->taxRateName }}</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

	@endcomponent

@endsection