@extends('layouts.app')

@section('content')

	<div class="container">

		<div class="row">
			<div class="col-3">
				<nav class="nav nav-pills flex-column mt-3">
					<a class="nav-link" href="{{ route('settings.index') }}" title="General Settings">
						General Settings
					</a>
					<a class="nav-link" href="{{ route('settings.index', 'invoice') }}" title="Invoice Settings">
						Invoice Settings
					</a>
					<a class="nav-link" href="#">Logo Settings</a>
				</nav>
			</div>
			<div class="col">
				@yield('settings-content')
			</div>
		</div>

	</div>

@endsection