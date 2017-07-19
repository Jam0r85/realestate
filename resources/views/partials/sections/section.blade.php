<section class="section has-divider">
	<div class="container">

		{{-- Title --}}
		@if (isset($title))
			<h2 class="title">{{ $title }}</h2>
		@endif

		{{-- Sub Title --}}
		@if (isset($subTitle))
			<h3 class="subtitle is-muted">{{ $subTitle }}</h3>
		@endif

		{{-- Content --}}
		{{ $slot }}
		
	</div>
</section>