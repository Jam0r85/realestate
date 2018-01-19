<form method="POST" action="{{ route('sms.print') }}" target="_blank">
	{{ csrf_field() }}

	<div class="text-right mb-2">
		<button type="submit" class="btn btn-secondary">
			@icon('print') Print Messages
		</button>
	</div>

	@foreach ($messages as $message)
	    @include('sms.partials.message')
	@endforeach

</form>