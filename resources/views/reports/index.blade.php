@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">Reports</h1>

			<hr />

			@include('partials.errors-block')

			<div class="columns">
				<div class="column is-6">

					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								HMRC Landlord Income
							</p>
						</header>
						<div class="card-content">

							<form role="form" method="POST" action="{{ route('reports.landlords-income') }}">
								{{ csrf_field() }}

								<div class="field">
									<label class="label" for="from">From</label>
									<div class="control">
										<input type="date" class="input" name="from" value="{{ old('from') }}" />
									</div>
								</div>

								<div class="field">
									<label class="label" for="until">Until</label>
									<div class="control">
										<input type="date" class="input" name="until" value="{{ old('until') }}" />
									</div>
								</div>

								<button type="submit" class="button is-primary">
									<span class="icon is-small">
										<i class="fa fa-book"></i>
									</span>
									<span>
										Generate
									</span>
								</button>

							</form>

						</div>
					</div>

				</div>
			</div>

		</div>
	</section>

@endsection