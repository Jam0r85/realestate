<section class="section">
	@if (isset($saveButton))
		<button type="submit" class="button is-success is-pulled-right">
			<span class="icon is-small">
				<i class="fa fa-save"></i>
			</span>
			<span>
				{{ $saveButton }}
			</span>
		</button>
	@endif

	{{-- Title --}}
	@if (isset($title))
		<h2 class="title is-3">{{ $title }}</h2>
	@endif

	{{-- Sub Title --}}
	@if (isset($subTitle))
		<h2 class="subtitle is-4">{{ $subTitle }}</h2>
	@endif

	{{-- Content --}}
	{{ $slot }}
</section>