@extends('layouts.app')

@section('breadcrumbs')
	<li class="is-active"><a>{{ $title }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $title }}
		@endslot
	@endcomponent

	@component('partials.sections.section')

		<div class="content">

			<form role="form" method="POST" action="{{ route('statements.search') }}">
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

		<form role="form" method="POST" action="{{ route('statements.send') }}">
			{{ csrf_field() }}
			@include('statements.partials.table', ['show_tenancy' => true, 'show_property' => true, 'send_statement' => $send_statement])
			@if ($send_statement)
				@component('partials.forms.buttons.primary')
					Send Statements
				@endcomponent
			@endif
		</form>
	@endcomponent

@endsection