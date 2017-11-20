@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Sent E-Mails History
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@component('partials.table')
			@slot('header')
				<th>Sent</th>				
				<th>Subject</th>
				<th>Recipient</th>
				<th class="text-right">Preview</th>
			@endslot
			@slot('body')
				@foreach ($emails as $email)
					<tr>
						<td>{{ date_formatted($email->created_at) }}</td>
						<td>{!! truncate($email->subject) !!}</td>
						<td>{{ $email->to }}</td>
						<td class="text-right">
							<a href="{{ route('emails.preview', $email->id) }}" target="_blank">
								View
							</a>
						</td>				
					</tr>
				@endforeach
			@endslot
		@endcomponent

		@include('partials.pagination', ['collection' => $emails])

	@endcomponent

@endsection