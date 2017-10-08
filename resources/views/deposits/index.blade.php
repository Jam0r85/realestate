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

		@include('deposits.partials.table')

	@endcomponent

@endsection