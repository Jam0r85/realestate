@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="mb-2 text-right">
			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="branchOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					@icon('options') Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="branchOptionsDropdown">
					<a class="dropdown-item" href="{{ route('branches.edit', $branch->id) }}">
						@icon('edit') Edit Branch
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			{{ $branch->name }}
		@endcomponent

		@component('partials.sub-header')
			{{ $branch->present()->addressInline }}
		@endcomponent
		
	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<ul class="nav nav-pills">
			<li class="nav-item">
				{!! Menu::showLink('Details', 'branches.show', $branch->id, 'index') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Staff', 'branches.show', $branch->id) !!}
			</li>
		</ul>

		@include('branches.show.' . $show)

	@endcomponent

@endsection