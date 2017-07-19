<section class="section has-divider">
	<div class="container">

		{{-- Title --}}
		@if (isset($title))
			<h2 class="title is-3">{{ $title }}</h2>
		@endif

		{{-- Content --}}
		{{ $slot }}
		
	</div>
</section>