@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('bank-accounts.show', $account->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $account->account_name }}</h1>
			<h2 class="subtitle">Edit Users</h2>

			<hr />

			<form role="form" method="POST" action="{{ route('bank-accounts.update-users', $account->id) }}">
				{{ csrf_field() }}

				<div class="card mb-2">
					<header class="card-header">
						<p class="card-header-title">
							Current Users
						</p>
					</header>

					<table class="table is-fullwidth is-striped is-bordered">
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
				</div>

				<div class="card mb-2">
					<header class="card-header">
						<p class="card-header-title">
							Attach New Users
						</p>
					</header>
					<div class="card-content">

						<div class="field">
							<label class="label" for="new_users">Search Users</label>
							<div class="control">
								<select name="new_users[]" class="select2" multiple>
									@foreach (users() as $user)
										@if (!$account->users->contains($user->id))
											<option value="{{ $user->id }}">{{ $user->name }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>

					</div>
				</div>

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Save Changes
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection