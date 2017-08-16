@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('statements.show', $statement->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">Statement #{{ $statement->id}}</h1>
			<h2 class="subtitle">Archive or delete this statement</h2>

			<hr />

			@if (!$statement->trashed())
				<form role="form" method="POST" action="{{ route('statements.archive', $statement->id) }}">
					{{ csrf_field() }}

					<div class="box mb-2">
						<div class="content">

							<h3>Archive Statement</h3>
							<p>You can archive this statement to prevent it from being included in any searches or results, etc. The statement is not deleted and can be restored statement at any time.</p>

						</div>

						<button type="submit" class="button is-danger">
							<span class="icon is-small">
								<i class="fa fa-archive"></i>
							</span>
							<span>
								Archive Statement
							</span>
						</button>

					</div>

				</form>
			@endif

			<form role="form" method="POST" action="{{ route('statements.destroy', $statement->id) }}">
				{{ csrf_field() }}

				<div class="box">
					<div class="content">

						<h3>Destroy Statement</h3>
						<p>You can destroy this statement and fully delete it from storage. <b>Once a statement has been destroyed it cannot be recovered!</b></p>

						<p>Please select from the options below:-</p>

					</div>

					<hr />

					<div class="field">
						<label class="checkbox">
							<input type="checkbox" name="paid_payments" value="true" />
							Destroy paid statement payments?
						</label>
					</div>

					<div class="field">
						<label class="checkbox">
							<input type="checkbox" name="unpaid_payments" value="true" checked />
							Destroy unpaid statement payments?
						</label>
					</div>

					@if ($statement->hasInvoice())
						<div class="field">
							<label class="checkbox">
								<input type="checkbox" name="invoice" value="true" checked />
								Destroy invoice #{{ $statement->invoice->number }} and it's items? 
							</label>
						</div>
					@endif

					@if (count($statement->expenses))
						<div class="has-text-danger mb-2">
							This statement was used to pay property expenses. These payments will be destroyed automatically when destroying this statement BUT the expenses will remain as paid.
						</div>
					@endif

					<button type="submit" class="button is-danger">
						<span class="icon is-small">
							<i class="fa fa-trash"></i>
						</span>
						<span>
							Destroy Statement
						</span>
					</button>

				</div>

			</form>

		</div>
	</section>

@endsection