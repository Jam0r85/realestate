@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">{{ $title }}</h1>

			<form role="form" method="POST" action="{{ route('statement-payments.search') }}">
				{{ csrf_field() }}

				<div class="field is-grouped">
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

			<hr />

			@include('statement-payments.partials.table')

		</div>
	</section>

@endsection