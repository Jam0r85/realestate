@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			SMS History
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@foreach ($messages as $message)

			<div class="card mb-3">

				@component('partials.card-header')
					<span class="float-right text-muted">
						<small>{{ $message->messageIds() }}</small>
					</span>

					{{ $message->recipient->present()->fullName }} ({{ $message->phone_number}})

					@slot('small')
						{{ datetime_formatted($message->created_at) }}
					@endslot
				@endcomponent

				<div class="card-body">

					<button type="button" class="float-right btn btn-sm btn-{{ $message->status('class') }}">
						{{ $message->status() }}
					</button>

					<p class="card-text">
						{{ $message->body }}
					</p>

					@if ($message->owner)
						<p class="card-text text-muted">
							<small>Sent by {{ $message->owner->present()->fullName }}</small>
						</p>
					@endif
					
				</div>

			</div>

		@endforeach

		@include('partials.pagination', ['collection' => $messages])

	@endcomponent

@endsection