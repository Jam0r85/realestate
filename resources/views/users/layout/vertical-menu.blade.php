<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

	@foreach ($sections as $section)
		<a class="nav-link {{ $loop->first ? 'active' : '' }}" id="v-pills-{{ str_slug($section) }}-tab" data-toggle="pill" href="#v-pills-{{ str_slug($section) }}" role="tab">
			{{ $section }}
		</a>
	@endforeach

</div>