@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					{{ $title }}
				</h1>
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

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('deposits.partials.table')

		</div>
	</section>

@endsection