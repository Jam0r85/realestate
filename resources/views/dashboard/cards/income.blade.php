<div class="card mb-5">
	<h4 class="card-header">
		{{ \Carbon\Carbon::now()->format('F Y') }} Income
	</h4>
	<div class="list-group list-group-flush">
		<div class="list-group-item">
			<span class="float-right">
				{{ currency($commission) }}
			</span>
			Commission
		</div>
		<div class="list-group-item">
			<span class="float-right">
				{{ currency($rent_received) }}
			</span>
			Rent Received
		</div>
	</div>
</div>