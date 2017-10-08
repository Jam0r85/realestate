@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					Services
					<a href="{{ route('services.create') }}" class="btn btn-primary">
						<i class="fa fa-plus"></i> New Service
					</a>
				</h1>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			<table class="table table-stiped table-hover table-responsive">
				<thead>
					<th>Name</th>
					<th>Letting Fee</th>
					<th>Re-Letting Fee</th>
					<th>Management</th>
					<th>Tax</th>
				</thead>
				<tbody>
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
				</tbody>
			</table>

		</div>
	</section>


@endsection