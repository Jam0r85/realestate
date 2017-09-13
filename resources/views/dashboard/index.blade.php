@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="row">
				<div class="col col-8">

					<div class="card text-white bg-danger mb-3">
						<div class="card-header">
							{{ count($overdue_tenancies) }} Overdue {{ str_plural('Tenancy', count($overdue_tenancies)) }}
						</div>
						<table class="table table-striped table-responsive">
							<thead>
								<th>Overdue</th>
								<th>Property</th>
								<th>Tenancy</th>
							</thead>
							<tbody>
								@foreach ($overdue_tenancies as $tenancy)
									<tr>
										<td>{{ $tenancy->days_overdue }} {{ str_plural('day', $tenancy->days_overdue) }}</td>
										<td>{{ $tenancy->property->short_name }}</td>
										<td>{{ $tenancy->name }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

				</div>
			</div>

		</div>
	</section>

@endsection