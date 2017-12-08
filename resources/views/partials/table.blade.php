<table class="table table-striped table-hover">
	@if (isset($header))
		<thead class="thead-dark">
			{{ $header }}
		</thead>
	@endif
	@if (isset($body))
		<tbody>
			{{ $body }}
		</tbody>
	@endif
</table>