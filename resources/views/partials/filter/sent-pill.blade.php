<li class="nav-item">
	<a class="nav-link @if (request('sent')) active @endif" href="{{ request('sent') ? Filter::link(['sent' => null]) : Filter::link(['sent' => true]) }}">
		Sent
	</a>
</li>