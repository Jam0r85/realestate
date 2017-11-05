<table class="table table-striped table-hover table-responsive-sm {{ user_setting('dark_mode') ? 'table-dark' : '' }}">
	@if (isset($header))
		<thead>
			{{ $header }}
		</thead>
	@endif
	@if (isset($body))
		<tbody>
			{{ $body }}
		</tbody>
	@endif
</table>