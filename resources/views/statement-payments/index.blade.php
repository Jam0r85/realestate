@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">{{ $title }}</h1>

			<hr />

			@include('statement-payments.partials.table')

		</div>
	</section>

@endsection