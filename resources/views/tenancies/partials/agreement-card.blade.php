<div class="card mb-3 @if (!$tenancy->current_agreement) bg-danger text-white @endif">
	<div class="card-header">
		<i class="fa fa-calendar"></i> Agreement
	</div>
	@if (!$tenancy->current_agreement)
		<div class="card-body">
			<b>
				No current tenancy agreement.
			</b><br />You can create one under the options dropdown.
		</div>
	@else
		<ul class="list-group list-group-flush">
			@component('partials.bootstrap.list-group-item')
				{{ date_formatted($tenancy->current_agreement->starts_at) }}
				@slot('title')
					Start Date
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ $tenancy->current_agreement->length_formatted }}
				@slot('title')
					Length
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ $tenancy->current_agreement->ends_at_formatted }}
				@slot('title')
					End Date
				@endslot
			@endcomponent
		</ul>
	@endif
</div>