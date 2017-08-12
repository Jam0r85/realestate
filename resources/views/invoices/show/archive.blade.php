@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('invoices.show', $invoice->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">Invoice #{{ $invoice->number }}</h1>
			<h2 class="subtitle">Archive Invoice</h2>

			<hr />

			<form role="form" method="POST" action="{{ route('invoices.archive', $invoice->id) }}">
				{{ csrf_field() }}

				<button type="submit" class="button is-danger">
					<span class="icon is-small">
						<i class="fa fa-archive"></i>
					</span>
					<span>
						Archive Invoice
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection