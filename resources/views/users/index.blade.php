@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">{{ $title }}</h1>

			<hr />

			<form role="form" method="POST" action="{{ route('users.search') }}">
				{{ csrf_field() }}

				<div class="field is-grouped">
					<div class="control">
						<a href="{{ route('users.create') }}" class="button is-primary is-outlined">
							<span class="icon is-small">
								<i class="fa fa-plus"></i>
							</span>
							<span>
								New User
							</span>
						</a>
					</div>
					<div class="control is-expanded">
						<input type="text" name="search_term" class="input" value="{{ session('search_term') }}" />
					</div>
					<div class="control">
						<button type="submit" class="button">
							<span class="icon is-small">
								<i class="fa fa-search"></i>
							</span>
							<span>
								Search
							</span>
						</button>
					</div>
				</div>
			</form>

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('users.partials.table', $users)

		</div>
	</section>

@endsection