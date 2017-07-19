<li @if ($path == Request::url()) class="is-active" @endif>
	<a href="{{ $path }}">{{ $slot }}</a>
</li>