@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('statements.show', $statement->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">Statement #{{ $statement->id}}</h1>
			<h2 class="subtitle">New expense item</h2>

			<hr />

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('statements.create-expense-item', $statement->id) }}">
				{{ csrf_field() }}				

				@include('expenses.partials.form')

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Create Item
					</span>
				</button>
			</form>

		</div>
	</section>

@endsection