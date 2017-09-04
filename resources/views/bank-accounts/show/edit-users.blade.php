@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('bank-accounts.show', $account->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $account->account_name }}</h1>
				<h2>Edit Users</h2>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('bank-accounts.update-users', $account->id) }}">
				{{ csrf_field() }}

				@if (!count($account->users))

					<div class="alert alert-danger">
						<b>No users linked!</b><br />No users have been linked to this account yet.
					</div>

				@else

					<table class="table table-striped table-responsive mb-3">
						<thead>
							<th width="100%">Name</th>
							<th class="has-text-right"><span class="has-text-danger">Remove?</span></th>
						</thead>
						<tbody>
							@foreach ($account->users as $user)
								<tr>
									<td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
									<td class="has-text-right"><input type="checkbox" name="remove[]" value="{{ $user->id }}" /></td>
								</tr>
							@endforeach
						</tbody>
					</table>

				@endif

				<div class="card mb-3">
					<div class="card-body">

						<div class="form-group">
							<label for="new_users">
								Search and choose the users you wish to link to this bank account
							</label>
							<select name="new_users[]" class="form-control select2" multiple>
								@foreach (users() as $user)
									@if (!$account->users->contains($user->id))
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