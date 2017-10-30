@component('partials.bootstrap.card-header')
	{{ $slot }}

	@if (isset($small))
		@slot('small')
			{{ $small }}
		@endslot
	@endif

	@if (isset($style))
		@slot('style')
			{{ $style }}
		@endslot
	@endif

@endcomponent