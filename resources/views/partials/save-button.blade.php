@component('partials.bootstrap.save-submit-button')
	{{ $slot }}

	@if (isset($disabled))
		@slot('disabled')
			{{ $disabled }}
		@endslot
	@endif
@endcomponent