@extends('layouts.app')

@section('content')

	@component('partials.sections.section')

		<div class="columns">
			<div class="column is-one-quarter">

				<aside class="menu">
					<p class="menu-label">
						General
					</p>
					@component('partials.menus.menu')
						@component('partials.menus.menu-item')
							@slot('path')
								{{ route('settings.index') }}
							@endslot
							Company Settings
						@endcomponent
					@endcomponent
					<p class="menu-label">
						Administration
					</p>
					@component('partials.menus.menu')
						<li>
							<a href="{{ route('settings.branches') }}" @if (route('settings.branches') == Request::url()) class="is-active" @endif>
								Branches
							</a>
							<ul>
								<li><a href="{{ route('settings.roles') }}" @if (route('settings.roles') == Request::url()) class="is-active" @endif>Branch Roles</a></li>
								<li>
									<a href="{{ route('settings.permissions') }}" @if (route('settings.permissions') == Request::url()) class="is-active" @endif>
										Permissions
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="{{ route('settings.user-groups') }}" @if (route('settings.user-groups') == Request::url()) class="is-active" @endif>
								User Groups
							</a>
						</li>
						<li>
							<a href="{{ route('settings.invoice-groups') }}" @if (route('settings.invoice-groups') == Request::url()) class="is-active" @endif>
								Invoice Groups
							</a>
						</li>
					@endcomponent
				</aside>

			</div>
			<div class="column">

				@yield('sub-content')

			</div>
		</div>

	@endcomponent

@endsection