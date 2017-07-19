@extends('layouts.app')

@section('content')

	{{-- Main Title and Area Navigation --}}
	@component('partials.sections.hero.container')
		@slot('title')
			Users
		@endslot

		@slot('footer')

			@component('partials.sections.hero.tab-item')
				List
				@slot('path')
					{{ route('users.index') }}
				@endslot
			@endcomponent

			@component('partials.sections.hero.tab-item')
				Archived
				@slot('path')
					{{ route('users.archived') }}
				@endslot
			@endcomponent

		@endslot
	@endcomponent

	@component('partials.nav')
		@slot('navRight')

			<form role="form" method="POST" action="{{ route('users.search') }}">
				{{ csrf_field() }}

				<span class="nav-item">
					<div class="field has-addons">
						<p class="control">
							@component('partials.forms.input')
								@slot('name')
									search_term
								@endslot
								@slot('value')
									{{ isset($search_term) ? $search_term : null }}
								@endslot
								@slot('placeholder')
									Search Users
								@endslot
							@endcomponent
						</p>	
						<p class="control">
							<button type="submit" class="button is-info">
								Search
							</button>
						</p>
					</div>
				</span>

			</form>

			@component('partials.nav-item')
				Create User
				@slot('path')
					{{ route('users.create') }}
				@endslot
			@endcomponent

		@endslot
	@endcomponent

	@yield('sub-content')

@endsection