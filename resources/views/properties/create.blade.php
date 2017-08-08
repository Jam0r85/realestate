@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">New Property</h1>

			<hr />

			@if (!count(branches()))

				<div class="notification">
					You must register a branch before you can start adding new properties.
				</div>

			@else

				@include('partials.errors-block')

				<form role="form" method="POST" action="{{ route('properties.store') }}">
					{{ csrf_field() }}

					<div class="field">
						<label class="label" for="branch_id">Branch</label>
						<p class="control is-expanded">
							<span class="select is-fullwidth">
								<select name="branch_id">
									@foreach (branches() as $branch)
										<option value="{{ $branch->id }}">{{ $branch->name }}</option>
									@endforeach
								</select>
							</span>
						</p>
					</div>

					@include('properties.partials.form')

					<div class="field">
						<label class="label" for="owner_id[]">Owners</label>
						<div class="control">
							<select name="owner_id[]" class="select2" multiple>
								@foreach (users() as $user)
									<option value="{{ $user->id }}">{{ $user->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<button type="submit" class="button is-primary">
						<span class="icon is-small">
							<i class="fa fa-save"></i>
						</span>
						<span>
							Create Property
						</span>
					</button>

				</form>

			@endif

		</div>
	</section>

@endsection