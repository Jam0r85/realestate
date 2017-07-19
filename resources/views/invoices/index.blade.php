@extends('layouts.app')

@section('breadcrumbs')
	<li class="is-active"><a>Invoices</a></li>
@endsection

@section('search_field')
	<form role="form" method="POST" action="{{ route('invoices.search') }}">
		{{ csrf_field() }}

		<span class="nav-item">
			<div class="field has-addons">
				<p class="control">
					@component('partials.forms.input')
						@slot('name')
							search_term
						@endslot
						@slot('value')
							{{ isset($search_term) ? $search_term : null }}
						@endslot
						@slot('placeholder')
							Search Invoices
						@endslot
					@endcomponent
				</p>	
				<p class="control">
					<button type="submit" class="button is-info">
						Search
					</button>
				</p>
			</div>
		</span>

	</form>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $title }}
		@endslot
	@endcomponent

	@component('partials.sections.section')
		@include('invoices.partials.table', ['invoices' => $invoices, 'property' => true, 'users' => true])
	@endcomponent

@endsection