@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					Expenses List
					<a href="{{ route('expenses.create') }}" class="btn btn-primary">
						<i class="fa fa-plus"></i> New Expense
					</a>
				</h1>
			</div>
			<div class="page-search">
				<form role="form" method="POST" action="{{ route('expenses.search') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<div class="input-group">
							{{-- Clear Search Button --}}
							@if (session('expenses_search_term'))
								<span class="input-group-btn">
									<button type="submit" class="btn btn-danger" name="clear_search" value="true">
										<i class="fa fa-trash"></i> Clear
									</button>
								</span>
							@endif
							<input type="text" name="search_term" class="form-control" placeholder="Search for..." value="{{ session('expenses_search_term') }}" />
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

	@if (count($unpaid_expenses) && $paid_expenses->currentPage() == 1)
		<section class="section">
			<div class="container">
				<div class="page-title">
					<h3 class="text-danger">
						Unpaid Expenses
					</h3>
				</div>

				<div class="row">
					<div class="col">
						@include('expenses.partials.unpaid-expenses-table', ['expenses' => $unpaid_expenses])
					</div>
				</div>
			</div>
		</section>
	@endif

	<section class="section">
		<div class="container">
			<div class="page-title">
				<h3 class="text-success">
					Paid Expenses
				</h3>
			</div>
			<div class="row">
				<div class="col">
					@include('expenses.partials.paid-expenses-table', ['expenses' => $paid_expenses])
				</div>
			</div>
		</div>
	</section>

@endsection