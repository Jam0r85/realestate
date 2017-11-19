@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Sent E-Mails History
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@foreach ($messages as $message)

			<div class="card mb-3">

				@component('partials.card-header')
					{{ $message->recipient->present()->fullName }}
					@slot('small')
						{{ datetime_formatted($message->created_at) }}
					@endslot
				@endcomponent

				<div class="card-body">
					{{ $message->body }}
					<button type="button" class="float-right btn btn-sm btn-{{ $message->status('class') }}">
						{{ $message->status() }}
					</button>
				</div>

			</div>

		@endforeach

		@include('partials.pagination', ['collection' => $messages])

	@endcomponent

@endsection