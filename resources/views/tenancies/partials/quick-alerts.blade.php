{{-- Tenancy Vacated Alert --}}
@if ($tenancy->vacated_on && $tenancy->vacated_on <= \Carbon\Carbon::now())
	@component('partials.alerts.warning')
		@icon('calendar')
		Tenancy ended on <b>{{ $tenancy->present()->date('vacated_on') }}</b>
	@endcomponent
@endif

{{-- Tenancy Vacating Alert --}}
@if ($tenancy->vacated_on && $tenancy->vacated_on > \Carbon\Carbon::now())
	@component('partials.alerts.warning')
		@icon('calendar')
		Tenancy ending on {{ $tenancy->present()->date('vacated_on') }}
	@endcomponent
@endif

{{-- Tenancy Not Started Alert --}}
@if (!$tenancy->started_on)
	@component('partials.alerts.info')
		@icon('calendar')
		@if ($tenancy->firstAgreement)
			Tenancy is due to start on {{ $tenancy->present()->dateStart }}
		@else
			Tenancy does not have an agreement!
		@endif
	@endcomponent
@endif

{{-- Tenancy Has Enough Rent Balance --}}
@if ($tenancy->hasEnoughRentBalance())
	@component('partials.alerts.info')
		Next statement is due to start on <b>{{ $tenancy->present()->date('next_statement_start_date') }}</b>
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

{{-- No property owners --}}
@if (! count($tenancy->property->owners))
	@component('partials.alerts.warning')
		@icon('users') The property {{ $tenancy->property->present()->shortAddress }} has no owners.
	@endcomponent
@endif

{{-- No property owners --}}
@if (! count($tenancy->property->owners))

	@component('partials.alerts.warning')
		@icon('users') The property {{ $tenancy->property->present()->shortAddress }} has no owners.
	@endcomponent

@else

	{{-- No assigned property --}}
	@if (! $tenancy->getLandlordProperty())
		@component('partials.alerts.warning')
			@icon('house') Tenancy has no correspondence address set.
		@endcomponent
	@endif

@endif