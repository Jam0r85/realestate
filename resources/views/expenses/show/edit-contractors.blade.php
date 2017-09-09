@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $expense->name }}</h1>
				<h3>Edit contractors</h3>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('expenses.update-contractors', $expense->id) }}">
				{{ csrf_field() }}

				@if (!count($expense->contractors))

					<div class="alert alert-danger">
						<b>No contractors!</b><br />No users have been added as contractors for this expense.
					</div>

				@else

					<div class="card bg-primary mb-3">
						<div class="card-header text-white">
							<i class="fa fa-users"></i> Current Contractors
						</div>
						<ul class="list-group list-group-flush">
							@foreach ($expense->contractors as $user)
								<li class="list-group-item">
									<div class="row">
										<div class="col">
											<a href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}">
												{{ $user->name }}
											</a>
										</div>
										<div class="col text-right">
											<label class="custom-control custom-checkbox">
												<input class="custom-control-input" type="checkbox" name="remove[]" value="{{ $user->id }}" />
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description">Remove?</span>
											</label>
										</div>
									</div>
								</li>
							@endforeach
						</ul>
					</div>

				@endif

				<div class="card mb-3">
					<div class="card-body">

						<div class="form-group">
							<label for="new_users">
								Search and choose the users you wish to add as contractors to this expense
							</label>
							<select name="new_contractors[]" class="form-control select2" multiple>
								@foreach (users() as $user)
									@if (!$expense->contractors->contains($user->id))
										<option value="{{ $user->id }}">{{ $user->name }}</option>
									@endif
								@endforeach
							</select>
						</div>

					</div>
				</div>

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Save Changes
				</button>

			</form>

		</div>
	</section>

@endsection