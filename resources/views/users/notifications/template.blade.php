@component('partials.card-header')
	{{ $header }}
@endcomponent

	{{ $slot }}

<div class="card-footer">
	{{ $footer }}
</div>