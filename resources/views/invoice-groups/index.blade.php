@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					Invoice Groups List
					<a href="{{ route('invoice-groups.create') }}" class="btn btn-primary">
						<i class="fa fa-plus"></i> New Invoice Group
					</a>
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