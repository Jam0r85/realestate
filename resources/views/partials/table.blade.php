<table class="table table-striped table-hover">
	@if (isset($header))
		<thead class="thead-light">
			{{ $header }}
		</thead>
	@endif
	@if (isset($footer))
		<tfoot>
			{{ $footer }}
		</tfoot>
	@endif
	@if (isset($body))
		<tbody>
			{{ $body }}
		</tbody>
	@endif
</table>