@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('properties.show', $property->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $property->short_name }}</h1>
				<h2>Archive this property</h2>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			@if ($property->trashed())

				<div class="card mb-3">
					<div class="card-body">
						<h4 class="card-title">
							Restore Property
						</h4>
						<p class="card-text">
							You can restore this property and bring it back to life.
						</p>

						<form role="form" method="POST" action="{{ route('properties.restore', $property->id) }}">
							{{ csrf_field() }}

							<button type="submit" class="btn btn-secondary">
								<i class="fa fa-save"></i> Restore Property
							</button>

						</form>
					</div>
				</div>

			@else

				<div class="card mb-3">
					<div class="card-body">
						<h4 class="card-title">
							Archive Property
						</h4>
						<p class="card-text">
							You can archive or 'soft delete' this property and hide it from public view. An archived property can be restored back as and when required.
						</p>

						<form role="form" method="POST" action="{{ route('properties.archive', $property->id) }}">
							{{ csrf_field() }}

							<button type="submit" class="btn btn-secondary">
								<i class="fa fa-archive"></i> Archive Property
							</button>

						</form>
					</div>
				</div>

			@endif
			
		</div>
	</section>

@endsection