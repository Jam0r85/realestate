{{-- Tenancy Vacated Alert --}}
@if ($tenancy->vacated_on && $tenancy->vacated_on <= \Carbon\Carbon::now())
	@component('partials.alerts.warning')
		@icon('calendar')
		Tenancy ended on {{ date_formatted($tenancy->vacated_on) }}
	@endcomponent
@endif

{{-- Tenancy Vacating Alert --}}
@if ($tenancy->vacated_on && $tenancy->vacated_on > \Carbon\Carbon::now())
	@component('partials.alerts.warning')
		@icon('calendar')
		Tenancy ending on {{ date_formatted($tenancy->vacated_on) }}
	@endcomponent
@endif

{{-- Tenancy Not Started Alert --}}
@if (!$tenancy->started_on)
	@component('partials.alerts.warning')
		@icon('calendar')
		@if ($tenancy->firstAgreement)
			Tenancy is due to start on {{ date_formatted($tenancy->firstAgreement->starts_at) }}
		@else
			Tenancy does not have an agreement!
		@endif
	@endcomponent
@endif

{{-- Tenancy Overdue Alert --}}
@if ($tenancy->is_overdue > 0)
	@component('partials.alerts.warning')
		This tenancy is <b>{{ $tenancy->is_overdue }} {{ str_plural('day', $tenancy->is_overdue) }}</b> overdue.
		@if ($tenancy->latestStatement)
			Latest statement end date was {{ date_formatted($tenancy->latestStatement->period_end) }}
		@endif
	@endcomponent
@endif