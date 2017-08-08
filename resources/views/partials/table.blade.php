<table class="table is-striped is-fullwidth">
	@if (isset($head))
		<thead>
			{{ $head }}
		</thead>
	@endif
	<tbody>
		{{ $slot }}
	</tbody>
</table>