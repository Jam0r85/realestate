<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-user"></i> User's Information
	</div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					Title
				</span>
				{{ $user->title }}
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					First Name
				</span>
				{{ $user->first_name }}
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					Last Name
				</span>
				{{ $user->last_name }}
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					Company Name
				</span>
				{{ $user->company_name }}
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					E-Mail
				</span>
				{{ $user->email }}
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					Mobile Phone
				</span>
				{{ $user->phone_number }}
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					Other Phone Number
				</span>
				{{ $user->phone_number_other }}
			</div>
		</li>
	</ul>
</div>