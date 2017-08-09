@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">New Bank Account</h1>

			<hr />

			<form role="form" method="POST" action="{{ route('bank-accounts.store') }}">
				{{ csrf_field() }}

				@include('partials.errors-block')

				@include('bank-accounts.partials.form')

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Create Bank Account
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection