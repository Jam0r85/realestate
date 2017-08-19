@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('tenancies.show', $tenancy->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $tenancy->name }}</h1>
			<h2 class="subtitle">Rent payments received</h2>

			<hr />

			@include('payments.partials.table', ['payments' => $tenancy->rent_payments])

		</div>
	</section>

@endsection