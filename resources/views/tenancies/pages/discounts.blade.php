@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Discounts
		@endcomponent

		<form role="form" method="POST" action="{{ route('tenancies.update-discounts', $tenancy->id) }}">
			{{ csrf_field() }}

			<div class="field">
				<label class="label">Discounts</label>

				@foreach (discounts() as $discount)
					<label class="checkbox">
						<input type="checkbox" name="discount_id[]" value="{{ $discount->id }}" @if ($tenancy->discounts->contains($discount->id)) checked @endif />
						{{ $discount->name }} - {{ $discount->amount_formatted }}
					</label>
				@endforeach

			</div>

			@component('partials.forms.buttons.primary')
				Update
			@endcomponent

		</form>

	@endcomponent

@endsection