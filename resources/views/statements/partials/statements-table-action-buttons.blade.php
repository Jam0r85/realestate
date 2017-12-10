@if ($statement->present()->status == 'Paid')
	<form method="POST" action="{{ route('statements.send', $statement->id) }}" class="d-inline">
		{{ csrf_field() }}
		<button type="submit" class="btn btn-info btn-sm">
			Send
		</button>
	</form>
@endif

<a href="{{ route('statements.show', $statement->id) }}" class="btn btn-warning btn-sm">
	View
</a>

<a href="{{ route('downloads.statement', $statement->id) }}" class="btn btn-primary btn-sm" target="_blank">
	Download
</a>