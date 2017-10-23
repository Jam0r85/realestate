@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<h1>
				{{ $title }}
			</h1>
		</div>

		<div class="btn-group mb-3">
			<button type="button" class="btn">
				Total <span class="badge badge-secondary">{{ currency($deposits->sum('amount')) }}</span>
			</button>
			<button type="button" class="btn @if ($deposit_balance < $deposits->sum('amount')) btn-danger @elseif ($deposit_balance == $deposits->sum('amount')) btn-success @endif">
				Current Held <span class="badge badge-secondary">{{ currency($deposit_balance) }}</span>
			</button>
		</div>
			
		<div class="page-search">
			<form role="form" method="POST" action="{{ route('deposit.search') }}">
				{{ csrf_field() }}
				<div class="form-group">
					<div class="input-group">
						{{-- Clear Search Button --}}
						@if (session('deposit_search_term'))
							<span class="input-group-btn">
								<button type="submit" class="btn btn-danger" name="clear_search" value="true">
									<i class="fa fa-trash"></i> Clear
								</button>
							</span>
						@endif
						<input type="text" name="search_term" class="form-control" placeholder="Search for..." value="{{ session('deposit_search_term') }}" />
						<span class="input-group-btn">
							<button type="submit" class="btn btn-secondary">
								<i class="fa fa-search"></i> Search
							</button>
						</span>
					</div>
				</div>
			</form>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<table class="table table-striped table-responsive">
			<thead>
				<th>Date</th>
				<th>Tenancy</th>
				<th>Amount</th>
				<th>Balance</th>
				<th>ID</th>
			</thead>
			<tbody>
				@foreach ($deposits as $deposit)
					<tr>
						<td>{{ date_formatted($deposit->created_at) }}</td>
						<td>
							<a href="{{ route('tenancies.show', $deposit->tenancy->id) }}" title="{{ $deposit->tenancy->name }}">
								{{ $deposit->tenancy->name }}
							</a>
						</td>
						<td>{{ currency($deposit->amount) }}</td>
						<td>
							<span class="@if ($deposit->balance < $deposit->amount) text-danger @endif">
								{{ currency($deposit->balance) }}
							</span>
						</td>
						<td>{{ $deposit->unique_id }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		@include('partials.pagination', ['collection' => $deposits])

	@endcomponent

@endsection