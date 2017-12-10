<li class="nav-item">
	<a class="nav-link @if (request('paid') == false) active @endif" href="{{ request('paid') == false ? Filter::link(['paid' => false]) : Filter::link(['paid' => false]) }}">
		Unpaid
	</a>
</li>