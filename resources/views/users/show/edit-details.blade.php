@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('users.show', $user->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $user->name }}</h1>
			<h2 class="subtitle">Edit Details</h2>

			<hr />

			<form role="form" method="POST" action="{{ route('users.update', $user->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				@include('partials.errors-block')

				@include('users.partials.form')

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