@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			@component('partials.header')
				Statement Payment {{ $payment->id }}
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

	@endcomponent

@endsection 