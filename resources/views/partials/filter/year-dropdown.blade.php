<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		{{ request('year') ?? 'Year' }}
	</a>
	<div class="dropdown-menu">
		<a class="dropdown-item @if (!request('year')) active @endif" href="{{ Filter::link(['year' => null]) }}">
			Any Year
		</a>
		<div class="dropdown-divider"></div>
		@foreach ($years as $year)
			<a class="dropdown-item @if (request('year') == $year) active @endif" href="{{ Filter::link(['year' => $year]) }}">
				{{ $year }}
			</a>
		@endforeach
	</div>
</li>