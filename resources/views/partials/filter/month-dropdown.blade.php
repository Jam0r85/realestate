<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		@icon('calendar') {{ request('month') ?? 'Month' }}
	</a>
	<div class="dropdown-menu">
		<a class="dropdown-item @if (!request('month')) active @endif" href="{{ Filter::link(['month' => null]) }}">
			All Months
		</a>
		<div class="dropdown-divider"></div>
		@foreach ($months as $month)
			<a class="dropdown-item @if (request('month') == $month) active @endif" href="{{ Filter::link(['month' => $month]) }}">
				{{ $month }}
			</a>
		@endforeach
	</div>
</li>