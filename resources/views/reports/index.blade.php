@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>Reports</h1>
			</div>

			@include('partials.errors-block')

			<div class="row">
				<div class="col col-6">

					<div class="card mb-2">
						<div class="card-header">
							HMRC Landlord Income
						</div>
						<div class="card-body">

							<form role="form" method="POST" action="{{ route('reports.landlords-income') }}">
								{{ csrf_field() }}

								<div class="form-group">
									<label for="from">From</label>
									<input type="date" class="form-control" name="from" value="{{ old('from') }}" />
								</div>

								<div class="form-group">
									<label for="until">Until</label>
									<input type="date" class="form-control" name="until" value="{{ old('until') }}" />
								</div>

								<button type="submit" class="btn btn-primary">
									<i class="fa fa-book"></i> Generate
								</button>

							</form>

						</div>
					</div>

				</div>
			</div>

		</div>
	</section>

@endsection