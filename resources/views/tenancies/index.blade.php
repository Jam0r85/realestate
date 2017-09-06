@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					{{ $title }}
					<a href="{{ route('tenancies.create') }}" class="btn btn-primary">
						<i class="fa fa-plus"></i> New Tenancy
					</a>
				</h1>
			</div>
			<div class="page-search">
				<form role="form" method="POST" action="{{ route('tenancies.search') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<div class="input-group">
							{{-- Clear Search Button --}}
							@if (session('tenancies_search_term'))
								<span class="input-group-btn">
									<button type="submit" class="btn btn-danger" name="clear_search" value="true">
										<i class="fa fa-trash"></i> Clear
									</button>
								</span>
							@endif
							<input type="text" name="search_term" class="form-control" placeholder="Search for..." value="{{ session('tenancies_search_term') }}" />
							<span class="input-group-btn">
								<button type="submit" class="btn btn-secondary">
									<i class="fa fa-search"></i> Search
								</button>
							</span>
						</div>
					</div>
				</form>
			</div>

			<div class="row">
				<div class="col">
					@include('tenancies.partials.table')
				</div>
			</div>

		</div>
	</section>

@endsection