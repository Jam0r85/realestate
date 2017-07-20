@extends('layouts.app')

@section('breadcrumbs')
	<li class="is-active"><a>Invoices</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $title }}
		@endslot
	@endcomponent

	@component('partials.sections.section')

		<div class="content">

			<form role="form" method="POST" action="{{ route('invoices.search') }}">
				{{ csrf_field() }}

				<div class="field is-grouped">
					<p class="control is-expanded">
						<input type="text" name="search_term" class="input" value="{{ session('search_term') }}" />
					</p>
					<p class="control">
						@component('partials.forms.buttons.primary')
							Search
						@endcomponent
					</p>
				</div>
			</form>

		</div>

		@include('invoices.partials.table', ['invoices' => $invoices, 'property' => true, 'users' => true])
	@endcomponent

@endsection