@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Permission
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<form action="{{ route('permissions.store') }}" method="POST">
			{{ csrf_field() }}

			<div class="row">
				<div class="col-12 col-lg-6">

					@component('partials.card')
						@slot('header')
							Permission Details
						@endslot

						<div class="card-body">

							@include('permissions.partials.form')

						</div>

						@slot('footer')
							@component('partials.save-button')
								Save Permission
							@endcomponent
						@endslot
					@endcomponent

				</div>
				<div class="col-12 col-lg-6">

					@component('partials.table')
						@slot('header')
							<th>Name</th>
							<th class="text-right">Slug</th>
						@endslot
						@slot('body')
							@foreach ($latestPermissions as $permission)
								<tr>
									<td>{{ $permission->name }}</td>
									<td class="text-right">{{ $permission->slug }}</td>
								</tr>
							@endforeach
						@endslot
					@endcomponent

				</div>
			</div>

		</form>

	@endcomponent

@endsection