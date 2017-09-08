@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					Branches List
					<a href="{{ route('branches.create') }}" class="btn btn-primary">
						<i class="fa fa-plus"></i> New Branch
					</a>
				</h1>
			</div>

			<table class="table table-striped table-responsive">
				<thead>
					<th>Name</th>
				</thead>
				<tbody>
				@foreach ($branches as $branch)
					<tr>
						<td>
							<a href="{{ route('branches.show', $branch->id) }}" title="{{ $branch->name }}">
								{{ $branch->name }}
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>

		</div>
	</section>

@endsection