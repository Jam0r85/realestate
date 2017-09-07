@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					Invoice Groups List
				</h1>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			<div class="row">
				<div class="col">
					@include('invoice-groups.partials.table', ['invoice_groups' => $invoice_groups])
				</div>
			</div>

		</div>
	</section>

@endsection