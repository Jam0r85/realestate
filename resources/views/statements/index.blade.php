@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container-fluid">

			<div class="page-title">
				<h1>Statements List</h1>
			</div>
			<div class="page-search">
				<form role="form" method="POST" action="{{ route('statements.search') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<div class="input-group">
							{{-- Clear Search Button --}}
							@if (session('statements_search_term'))
								<span class="input-group-btn">
									<button type="submit" class="btn btn-danger" name="clear_search" value="true">
										<i class="fa fa-trash"></i> Clear
									</button>
								</span>
							@endif
							<input type="text" name="search_term" class="form-control" placeholder="Search for..." value="{{ session('statements_search_term') }}" />
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
		<div class="container-fluid">

			<h3 class="text-danger">
				Unsent Statements
			</h3>

		</div>
	</section>

	<section class="section">
		<div class="container-fluid">

			<h3 class="text-success">
				Sent Statements
			</h3>

			<div class="row">
				<div class="col">
					@include('statements.partials.sent-statements-table', ['statements' => $sent_statements])
				</div>
			</div>

		</div>
	</section>

@endsection