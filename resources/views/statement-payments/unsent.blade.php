@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('statements.index') }}">Statements List</a></li>
	<li class="is-active"><a>Unsent Statement Payments</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			Unsent Payments
		@endslot
	@endcomponent

	@component('partials.sections.section')

		<form role="form" method="POST" action="{{ route('statement-payments.mark-sent') }}">
			{{ csrf_field() }}

			@include('partials.errors-block')

			@foreach ($groups as $name => $payments)

				@component('partials.subtitle')
					{{ ucwords($name) }} {{ currency($payments->sum('amount')) }}
				@endcomponent

				@include('statement-payments.partials.'.$name.'-table')

				<hr />

			@endforeach

			<button type="submit" class="button is-primary is-outlined">
				Mark as Sent
			</button>

		</form>

	@endcomponent

@endsection