@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('permissions.create') }}" class="btn btn-primary float-right">
			@icon('plus') New Permission
		</a>

		@component('partials.header')
			Permissions
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@component('partials.alerts.info')
			@icon('info') <b>How does permissions and access work?</b>
			<p>
				Access to a viewing, creating, showing, updating and deleting records is set out as follows:-
			</p>
			<ul>
				<li>Is the user a super admin as set by the server environment?</li>
				<li>Does the user have the correct permissions set in their profile to access these records?</li>
				<li>Is the user a staff member?</li>
				<li>Does the user own the record?</li>
			</ul>
		@endcomponent

		@include('permissions.partials.table')
		@include('partials.pagination', ['collection' => $permissions])

	@endcomponent

@endsection