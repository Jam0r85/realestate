<div class="card">
	@if (isset($cardHeader))
		<header class="card-header">
			<p class="card-header-title">
				{{ $cardHeader }}
			</p>
		</header>
	@endif
	@if (isset($cardContent))
		<div class="card-content">
			<div class="content">
				{{ $cardContent }}
			</div>
		</div>
	@endif
	@if (isset($cardFooter))
		<footer class="card-footer">
			{{ $cardFooter }}
		</footer>
	@endif
</div>