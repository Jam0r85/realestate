<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-cogs"></i> System Information
	</div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				{{ $user->branch ? $user->branch->name : '' }}
				<span class="text-muted">
					Branch
				</span>
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				{{ date_formatted($user->created_at) }}
				<span class="text-muted">
					Registered
				</span>
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				{{ date_formatted($user->updated_at) }}
				<span class="text-muted">
					Updated
				</span>
			</div>
		</li>
	</ul>
</div>