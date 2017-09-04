@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<div class="float-right">
					@include('users.partials.dropdown-menus')
				</div>
				<h1>{{ $user->name }}</h1>
			</div>

			<div class="row">
				<div class="col col-5">

					@include('users.partials.home-address-card')
					@include('users.partials.system-info-card')

				</div>
				<div class="col col-7">

					@include('users.partials.user-info-card')

				</div>
			</div>

			<hr />

			<ul class="nav nav-tabs" id="userTabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#properties" role="tab">Properties</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#invoices" role="tab">Invoices</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#expenses" role="tab">Expenses</a>
				</li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="properties" role="tabpanel">

					<table class="table table-striped table-responsive">
						<thead>
							<th>Name</th>
						</thead>
						<tbody>
							@foreach ($user->properties as $property)
								<tr>
									<td><a href="{{ route('properties.show', $property->id) }}">{{ $property->name }}</a></td>
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>
				<div class="tab-pane" id="invoices" role="tabpanel">

					@include('users.partials.recent-invoices')

				</div>
				<div class="tab-pane" id="expenses" role="tabpanel">

					<table class="table table-striped table-responsive">
						<thead>
							<th>Name</th>
							<th>Cost</th>
							<th>Balance</th>
							<th>Date</th>
						</thead>
						<tbody>
							@foreach ($user->expenses()->limit(5)->get() as $expense)
								<tr>
									<td><a href="{{ route('expenses.show', $expense->id) }}">{{ $expense->name }}</a></td>
									<td>{{ currency($expense->cost) }}</td>
									<td>{{ currency($expense->balance_amount) }}</td>
									<td>{{ date_formatted($expense->created_at) }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>
			</div>

		</div>
	</section>

@endsection