<li class="nav-item">
	<a class="nav-link @if (request('unpaid')) active @endif" href="{{ request('unpaid') ? Filter::link(['unpaid' => null]) : Filter::link(['unpaid' => true]) }}">
		Unpaid
	</a>
</li>