@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('bank-accounts.show', $account->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $account->account_name }}</h1>
			<h2 class="subtitle">Edit Details</h2>

			<hr />

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('bank-accounts.update', $account->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				@include('bank-accounts.partials.form')

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