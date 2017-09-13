@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="row">
				<div class="col col-6">

					<div class="card bg-danger mb-3">
						<div class="card-header text-white">
							{{ count($overdue_tenancies) }} Overdue {{ str_plural('Tenancy', count($overdue_tenancies)) }}
						</div>
						<ul class="list-group list-group-flush">
							@foreach ($overdue_tenancies as $tenancy)
								@component('partials.bootstrap.list-group-item')
									<a href="{{ route('tenancies.show', $tenancy->id) }}" title="{{ $tenancy->name }}">
										{{ $tenancy->name }}
									</a>
									@slot('title')
										{{ $tenancy->is_overdue }} {{ str_plural('day', $tenancy->is_overdue) }}
									@endslot
								@endcomponent
							@endforeach
						</ul>
					</div>

				</div>
			</div>

		</div>
	</section>

@endsection