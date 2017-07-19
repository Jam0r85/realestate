<table class="table is-striped is-bordered">
	@if (isset($head))
		<thead>
			{{ $head }}
		</thead>
	@endif
	<tbody>
		{{ $slot }}
	</tbody>
</table>