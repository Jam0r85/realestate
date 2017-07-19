<section class="hero {{ isset($style) ? $style : 'is-primary' }}">

	{{-- Hero Body --}}
	<div class="hero-body">
		<div class="container">
			<div class="is-pulled-right">
				@yield('search_field')
			</div>
			@if (isset($title))
				<h1 class="title">
					{{ $title }}
				</h1>
			@endif
			@if (isset($subTitle))
				<h2 class="subtitle">
					{{ $subTitle }}
				</h2>
			@endif
			{{ $slot }}
		</div>
	</div>

	{{-- Hero Footer --}}
	@if (isset($footer))
		@component('partials.sections.hero.footer')
			{{ $footer }}
		@endcomponent
	@endif

</section>