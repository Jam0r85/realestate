<div>
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
		<h2 class="title">{{ $title }}</h2>
	@endif

	{{-- Sub Title --}}
	@if (isset($subTitle))
		<h3 class="subtitle">{{ $subTitle }}</h3>
	@endif

	{{-- Content --}}
	{{ $slot }}
</div>