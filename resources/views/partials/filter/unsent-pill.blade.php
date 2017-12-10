<li class="nav-item">
	<a class="nav-link @if (request('unsent')) active @endif" href="{{ request('unsent') ? Filter::link(['unsent' => null]) : Filter::link(['unsent' => true]) }}">
		Unsent
	</a>
</li>