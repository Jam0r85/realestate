@extends('layouts.app')

@section('breadcrumbs')
	<li class="is-active"><a>{{ $title }}</a></li>
@endsection

@section('search_field')
	<form role="form" method="POST" action="{{ route('properties.search') }}">
		{{ csrf_field() }}

		<span class="nav-item">
			<div class="field has-addons">
				<p class="control">
					@component('partials.forms.input')
						@slot('name')
							search_term
						@endslot
						@slot('value')
							{{ old('search_term') }}
						@endslot
						@slot('placeholder')
							Search Properties
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

		@include('properties.partials.table')

	@endcomponent

@endsection