<li class="nav-item">
	<a class="nav-link @if (request('paid')) active @endif" href="{{ request('paid') ? Filter::link(['paid' => null]) : Filter::link(['paid' => true]) }}">
		Paid
	</a>
</li>