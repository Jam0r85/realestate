@if (count($invoice->statements))
	<div class="card mb-3">

		@component('partials.card-header')
			Statements
		@endcomponent

		<div class="list-group list-group-flush">
			@foreach ($invoice->statements as $statement)
				<a href="{{ route('statements.show', $statement->id) }}" class="list-group-item list-group-item-action">
					{{ $statement->present()->name }}
				</a>
			@endforeach
		</div>
		
	</div>
@endif