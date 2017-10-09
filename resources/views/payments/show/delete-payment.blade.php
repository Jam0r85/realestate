@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')
		<div class="page-title">
			<a href="{{ route('payments.show', $payment->id) }}" class="btn btn-secondary float-right">
				Return
			</a>
			<h1>Payment {{ $payment->id }}</h1>
			<h3>Edit payment details</h3>
		</div>
	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form role="form" method="POST" action="{{ route('payments.destroy', $payment->id) }}">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}

			<div class="card border-danger">
				<div class="card-body">

					<h4 class="card-title">
						Destroy Payment
					</h4>

					<p class="card-text">
						You can destroy this payment which will permenantly remove it from the system.
					</p>

					<div class="alert alert-danger">
						<b>Important!</b> This action cannot be reversed.
					</div>

					<p class="card-text">
						Enter the ID ({{ $payment->id }}) of this payment into the field below to confirm that you wish to destroy it.
					</p>

					<div class="form-group">
						<input type="text" name="confirmation" class="form-control" />
					</div>

					<button type="submit" class="btn btn-danger">
						<i class="fa fa-trash"></i> Destroy Payment
					</button>

				</div>
			</div>

		</form>

	@endcomponent

@endsection