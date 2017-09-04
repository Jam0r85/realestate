@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('bank-accounts.show', $account->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $account->account_name }}</h1>
				<h3>Edit account details</h3>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('bank-accounts.update', $account->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				@include('bank-accounts.partials.form')

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Save Changes
				</button>

			</form>

		</div>
	</section>

@endsection