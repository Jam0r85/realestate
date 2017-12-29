<table class="table table-bordered">
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