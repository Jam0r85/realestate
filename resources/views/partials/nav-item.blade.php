<a class="nav-item @if ($path == Request::url()) is-active @endif is-tab" href="{{ $path }}">
	{{ $slot }}
</a>