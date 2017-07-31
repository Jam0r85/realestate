@extends('statements.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Delete the Statement
		@endcomponent

		<div class="content">
			<p>
				Are you really sure that you want to delete this statement?
			</p>
		</div>

		<form role="form" method="POST" action="{{ route('statements.delete', $statement->id) }}">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}

			<button type="submit" class="button is-danger is-outlined">
				Yes, Delete Statement
			</button>

		</form>

	@endcomponent

@endsection