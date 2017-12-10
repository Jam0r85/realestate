<li class="nav-item">
	<a class="nav-link @if (request('sent') == false) active @endif" href="{{ request('sent') == false ? Filter::link(['sent' => false]) : Filter::link(['sent' => false]) }}">
		Unsent
	</a>
</li>