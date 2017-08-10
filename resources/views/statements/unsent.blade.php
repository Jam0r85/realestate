@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">Unset Statements</h1>
			<h2 class="subtitle">List of unsent statements waiting to be sent to their owners.</h2>

			<hr />

			@if (!count($statements))
				<div class="notification">
					We found no unsent statements.
				</div>
			@else

				<div class="notification">
					Please note that statements can only be sent once they have been paid.
				</div>

				<form role="form" method="POST" action="{{ route('statements.send') }}">
					{{ csrf_field() }}

					<table class="table is-striped is-fullwidth">
						<thead>
							<th></th>
							<th>Period</th>
							<th>Tenancy &amp; Property</th>
							<th>Amount</th>
							<th>Send By</th>
							<th>E-Mails</th>
							<th>Paid</th>
						</thead>
						<tbody>
							@foreach ($statements as $statement)
								<tr>
									<td>
										@if ($statement->paid_at)
											<input type="checkbox" name="statements[]" value="{{ $statement->id }}" />
										@endif
									</td>
									<td><a href="{{ route('statements.show', $statement->id) }}">{{ date_formatted($statement->period_start) }} - {{ date_formatted($statement->period_end) }}</a></td>
									<td>
										{{ $statement->tenancy->name }}
										<br />
										<a href="{{ route('properties.show', $statement->property->id) }}">
											<span class="tag is-light">
												{{ $statement->property->short_name }}
											</span>
										</a>
									</td>
									<td>{{ currency($statement->amount) }}</td>
									<td>{{ $statement->sendByPost() ? 'Post' : 'E-Mail' }}</td>
									<td>
										@foreach ($statement->getUserEmails() as $email)
											<span class="tag is-primary">
												{{ $email }}
											</span>
										@endforeach
									</td>
									<td>{!! $statement->paid_at ? '<span class="tag is-success">Paid ' . date_formatted($statement->paid_at) .'</span>' : '<span class="tag is-danger">Not Paid</span>' !!}</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					<button type="submit" class="button is-primary">
						<span class="icon is-small">
							<i class="fa fa-envelope-open"></i>
						</span>
						<span>
							Send Statements
						</span>
					</button>

				</form>

			@endif

		</div>
	</section>

@endsection