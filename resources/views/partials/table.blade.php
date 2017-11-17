<table class="table table-striped table-hover table-responsive-lg">
	@if (isset($header))
		<thead class="{{ user_setting('dark_mode') ? 'thead-dark' : '' }}">
			{{ $header }}
		</thead>
	@endif
	@if (isset($body))
		<tbody>
			{{ $body }}
		</tbody>
	@endif
</table>