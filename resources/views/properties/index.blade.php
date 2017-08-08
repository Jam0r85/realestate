@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">{{ $title }}</h1>

			<hr />

			<form role="form" method="POST" action="{{ route('properties.search') }}">
				{{ csrf_field() }}

				<div class="field is-grouped">
					<div class="control">
						<a href="{{ route('properties.create') }}" class="button is-primary is-outlined">
							<span class="icon is-small">
								<i class="fa fa-plus"></i>
							</span>
							<span>
								New Property
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

			<div class="content">
				<span class="tag is-medium is-primary">
					Owner
				</span>
				<span class="tag is-medium is-success">
					Owner &amp; Occupier
				</span>
			</div>

			@include('properties.partials.table')

		</div>
	</section>

@endsection