@extends('layouts.app')

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			Sent E-Mails
		@endslot
	@endcomponent

	@component('partials.sections.section')

		@component('partials.table')
			@slot('head')
				<th>Sent</th>				
				<th>Subject</th>
				<th>Recipient</th>
				<th>Users</th>
				<th>Options</th>
			@endslot
			@foreach ($emails as $email)
				<tr>
					<td>{{ datetime_formatted($email->created_at) }}</td>
					<td>{{ $email->subject }}</td>
					<td>{{ $email->to }}</td>
					<td></td>
					<td>
						<a href="{{ route('emails.preview', $email->id) }}" target="_blank" class="button is-small is-outlined is-primary">
							View E-Mail
						</a>
					</td>				
				</tr>
			@endforeach
		@endcomponent

		@include('partials.pagination', ['collection' => $emails])

	@endcomponent

@endsection