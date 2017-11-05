@if ($invoice->statement)
	<div class="card mb-3">

		@component('partials.card-header')
			Linked to Statement {{ $invoice->statement->id }}
		@endcomponent

		<div class="card-body">
			<p class="card-text">
				This invoice is attached to a rental statement.
			</p>

			<a href="{{ route('statements.show', $invoice->statement->id) }}" class="btn btn-primary">
				View Statement
			</a>
		</div>
		
	</div>
@endif