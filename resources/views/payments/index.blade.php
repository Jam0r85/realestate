@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Payments List
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.index-search', ['route' => 'payments.search', 'session' => 'payment_search_term'])

		<ul class="nav nav-pills">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ request('method') ? slug_to_name(request('method')) : 'Method' }}
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item @if (!request('method')) active @endif" href="{{ Filter::link(['method' => null]) }}">
						All Methods
					</a>
					<div class="dropdown-divider"></div>
					@foreach (payment_methods() as $method)
						<a class="dropdown-item @if (request('method') == $method->slug) active @endif" href="{{ Filter::link(['method' => $method->slug]) }}">
							{{ $method->name }}
						</a>
					@endforeach
				</div>
			</li>
		</ul>

		@include('payments.partials.payments-table')
		@include('partials.pagination', ['collection' => $payments])

	@endcomponent

@endsection