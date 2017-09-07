@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					Sent E-Mails History
				</h1>
			</div>

			<table class="table table-striped table-responsive">
				<thead>
					<th>Sent</th>				
					<th>Subject</th>
					<th>Recipient</th>
					<th class="text-right">Preview</th>
				</thead>
				<tbody>
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
				</tbody>
			</table>

			@include('partials.pagination', ['collection' => $emails])

		</div>
	</section>

@endsection