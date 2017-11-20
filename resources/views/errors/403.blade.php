@extends('errors.template')

@section('content')

	<p class="lead">
		{{ $exception->getMessage() }}
	</p>

@endsection