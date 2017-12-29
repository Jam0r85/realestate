@component('partials.bootstrap.save-submit-button')
	@icon('save') {{ $slot }}

	@if (isset($disabled))
		@slot('disabled')
			{{ $disabled }}
		@endslot
	@endif
@endcomponent