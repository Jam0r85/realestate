<div class="card mb-5">
	<h4 class="card-header">
		Tenancies
	</h4>
	<div class="list-group list-group-flush">
		<a href="{{ route('tenancies.overdue') }}" class="list-group-item list-group-item-action">
			<span class="float-right">
				{{ $overdue_tenancies }}
			</span>
			Tenancies in arrears
		</a>
		<a href="{{ route('tenancies.index') }}" class="list-group-item list-group-item-action">
			<span class="float-right">
				{{ $active_tenancies }}
			</span>
			Active tenancies
		</a>
	</div>
</div>