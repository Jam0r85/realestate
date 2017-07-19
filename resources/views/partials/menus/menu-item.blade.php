<li>
	<a href="{{ $path }}" @if ($path == Request::url()) class="is-active" @endif>
		{{ $slot }}
	</a>
</li>