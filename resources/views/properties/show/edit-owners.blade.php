@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('properties.show', $property->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $property->name }}</h1>
			<h2 class="subtitle">Update Owners</h2>
		
			<hr />

			<form role="form" method="POST" action="{{ route('properties.update-owners', $property->id) }}">
				{{ csrf_field() }}

				<div class="card mb-2">
					<header class="card-header">
						<p class="card-header-title">
							Current Owners
						</p>
					</header>

					<table class="table is-fullwidth is-striped">
						<thead>
							<th>Name</th>
							<th>
								<span class="is-pulled-right has-text-primary">
									Set {{ $property->short_name }} as Home?
								</span>
								Home
							</th>
							<th><span class="has-text-danger">Remove?</span></th>
						</thead>
						<tbody>
							@foreach ($property->owners as $owner)
								<tr>
									<td><a href="{{ route('users.show', $owner->id) }}">{{ $owner->name }}</a></td>
									<td>
										<div class="is-pulled-right">
											<input type="checkbox" name="home_address[]" value="{{ $owner->id }}" @if ($owner->property_id == $property->id) checked @endif />
										</div>
										{{ $owner->home ? $owner->home->name : '' }}
									</td>
									<td><input type="checkbox" name="remove[]" value="{{ $owner->id }}" /></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="card mb-2">
					<header class="card-header">
						<p class="card-header-title">
							Attach New Owners
						</p>
					</header>
					<div class="card-content">

						<div class="field">
							<label class="label" for="new_owners">Search Users</label>
							<div class="control">
								<select name="new_owners[]" class="select2" multiple>
									@foreach (users() as $user)
										@if (!$property->owners->contains($user->id))
											<option value="{{ $user->id }}">{{ $user->name }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>

					</div>
				</div>

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Save Changes
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection