<li class="nav-item">
	<a class="nav-link @if (request('archived')) active @endif" href="{{ request('archived') ? Filter::link(['archived' => null]) : Filter::link(['archived' => true]) }}">
		Archived
	</a>
</li>