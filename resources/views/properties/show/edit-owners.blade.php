@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('properties.show', $property->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $property->short_name }}</h1>
				<h2>Update Owners</h2>
			</div>

			<form role="form" method="POST" action="{{ route('properties.update-owners', $property->id) }}">
				{{ csrf_field() }}

				@if (!count($property->owners))

					<div class="alert alert-danger">
						<b>No owners!</b><br />No users have been added as owners to this property.
					</div>

				@else

					<div class="card bg-primary mb-3">
						<div class="card-header text-white">
							<i class="fa fa-users"></i> Current Owners
						</div>
						<ul class="list-group list-group-flush">
							@foreach ($property->owners as $user)
								<li class="list-group-item">
									<div class="row">
										<div class="col">
											<a href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}">
												{{ $user->name }}
											</a>
										</div>
										<div class="col">
											<label class="custom-control custom-checkbox">
												<input class="custom-control-input" type="checkbox" name="home_address[]" value="{{ $user->id }}" @if ($user->property_id == $property->id) checked @endif />
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description">{{ $user->home ? $user->home->short_name : 'Set as Home?' }}</span>
											</label>
										</div>
										<div class="col text-right">
											<label class="custom-control custom-checkbox">
												<input class="custom-control-input" type="checkbox" name="remove[]" value="{{ $user->id }}" />
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description">Remove?</span>
											</label>
										</div>
									</div>
								</li>
							@endforeach
						</ul>
					</div>

				@endif

				<div class="card mb-3">
					<div class="card-body">

						<div class="form-group">
							<label for="new_users">
								Search and choose the users you wish to add as owners to this property
							</label>
							<select name="new_owners[]" class="form-control select2" multiple>
								@foreach (users() as $user)
									@if (!$property->owners->contains($user->id))
										<option value="{{ $user->id }}">{{ $user->name }}</option>
									@endif
								@endforeach
							</select>
						</div>

					</div>
				</div>

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Save Changes
				</button>

			</form>

		</div>
	</section>

@endsection