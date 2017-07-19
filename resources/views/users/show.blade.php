@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('users.index') }}">Users</a></li>
	<li class="is-active"><a>{{ $user->name }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $user->name }}
		@endslot
	@endcomponent

	<section class="section">
		<div class="container">

			@include('partials.errors-block')

			<div class="tile is-ancestor">
				<div class="tile is-vertical is-8">
					<div class="tile">
						<div class="tile is-parent is-vertical">
							@if ($user->trashed())
								<article class="tile is-child notification is-dark">
									<p class="title">Archived</p>
									<div class="content">
										<p>This user's account has been archived.</p>
									</div>
								</article>
								<article class="tile is-child notification is-warning">
									<div class="content">
										<p>You can restore this user and allow their account to  be usedin future.</p>
									</div>
									<form role="form" method="POST" action="{{ route('users.restore', $user->id) }}">
										{{ csrf_field() }}
										<button type="submit" class="button">
											Restore this User
										</button>
									</form>
								</article>
							@else
								<article class="tile is-child notification is-success">
									<p class="title">Active</p>
									<div class="content">
										<p>This user's account is active and the user can login, view their profile, upodate their details.</p>
									</div>
								</article>
								<article class="tile is-child notification is-light">
									@if (Auth::id() == $user->id)
										<div class="content">
											<p><b>You cannot archive your own account silly!</b></p>
										</div>
									@else
										<div class="content">
											<p>You can archive this user and prevent their account from being used in future.</p>
										</div>
										<form role="form" method="POST" action="{{ route('users.archive', $user->id) }}">
											{{ csrf_field() }}
											<button type="submit" class="button">
												Archive this User
											</button>
										</form>
									@endif
								</article>
							@endif
							<article class="tile is-child box">
								<p class="title">Login History</p>
								<table class="table">
									<thead>
										<th>Date</th>
										<th>IP</th>
									</thead>
									<tbody>
										@foreach ($user->recentLogins as $login)
											<tr>
												<td>{{ datetime_formatted($login->created_at) }}</td>
												<td>{{ $login->ip }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</article>
						</div>
						<div class="tile is-parent is-vertical">
							<article class="tile is-child box">
								<p class="title">
									<button type="button" class="button is-warning is-pulled-right modal-button" data-target="{{ route('users.edit', $user->id) }}">
										Edit
									</button>
									Account Details
								</p>
								<dl>
									<dt>Name</dt>
									<dd>{{ $user->name }}</dd>
									<dt>E-Mail</dt>
									<dd>{{ $user->email ?: 'None' }}</dd>
									<dt>Mobile Phone</dt>
									<dd>{{ $user->phone_number ?: 'None'}}</dd>
									<dt>Other Phone Number</dt>
									<dd>{{ $user->phone_number_other ?: 'None' }}</dd>
								</dl>
							</article>

							{{-- Update E-Mail or Password Toggles --}}
							<article class="tile is-child box">
								<p class="title">Update Contact Details</p>

								<button type="button" class="button is-primary toggle-update-email">
									<span class="icon is-small">
										<i class="fa fa-edit"></i>
									</span>
									<span>
										E-Mail
									</span>
								</button>

								<button type="button" class="button is-primary toggle-update-phones">
									<span class="icon is-small">
										<i class="fa fa-edit"></i>
									</span>
									<span>
										Phones
									</span>
								</button>

								<button type="button" class="button is-primary toggle-update-password">
									<span class="icon is-small">
										<i class="fa fa-edit"></i>
									</span>
									<span>
										Password
									</span>
								</button>

								{{-- Update E-Mail Form --}}
								<div id="updateEmailForm">
									<form role="form" method="POST" action="{{ route('users.update-email', $user->id) }}">
										{{ csrf_field() }}
										{{ method_field('PUT') }}
										<hr />
										<div class="field">
											<label class="label" name="email">
												New E-Mail
											</label>
											<p class="control">
												<input type="email" name="email" class="input" value="{{ old('email') }}" />
											</p>
										</div>
										<div class="field">
											<label class="label" name="email_confirmation">
												Confirm E-Mail
											</label>
											<p class="control">
												<input type="email" name="email_confirmation" class="input" value="{{ old('email_confirmation') }}" />
											</p>
										</div>
										<button type="submit" class="button is-success">
											Update E-Mail
										</button>
									</form>
								</div>

								{{-- Update Phones Form --}}
								<div id="updatePhonesForm">
									<form role="form" method="POST" action="{{ route('users.update-phone', $user->id) }}">
										{{ csrf_field() }}
										{{ method_field('PUT') }}
										<hr />
										<div class="field">
											<label class="label" name="phone_number">
												Mobile Phone
											</label>
											<p class="control">
												<input type="text" name="phone_number" class="input" value="{{ old('phone_number') ?: $user->phone_number }}" />
											</p>
										</div>
										<div class="field">
											<label class="label" name="phone_number_other">
												Other Phone Number
											</label>
											<p class="control">
												<input type="text" name="phone_number_other" class="input" value="{{ old('phone_number_other') ?: $user->phone_number_other }}" />
											</p>
										</div>
										<button type="submit" class="button is-success">
											Update Phone Numbers
										</button>
									</form>
								</div>				

								{{-- Update the Password Form --}}
								<div id="updatePasswordForm">
									<form role="form" method="POST" action="{{ route('users.update-password', $user->id) }}">
										{{ csrf_field() }}
										{{ method_field('PUT') }}
										<hr />
										<div class="field">
											<label class="label" name="password">
												New Password
											</label>
											<p class="control">
												<input type="password" name="password" class="input" />
											</p>
										</div>
										<div class="field">
											<label class="label" name="password_confirmation">
												Confirm Password
											</label>
											<p class="control">
												<input type="password" name="password_confirmation" class="input" />
											</p>
										</div>
										<button type="submit" class="button is-success">
											Update Password
										</button>
									</form>
								</div>

							</article>

							<article class="tile is-child box">
								<p class="title">Information</p>
								<dl>
									<dt>Registered</dt>
									<dd>{{ date_formatted($user->created_at) }}</dd>
									<dt>Updated</dt>
									<dd>{{ datetime_formatted($user->updated_at) }}</dd>
								</dl>
							</article>
						</div>
					</div>
				</div>
				<div class="tile is-parent is-vertical">
					<article class="tile is-child box">
						<form role="form" method="POST" action="{{ route('users.update-groups', $user->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}
							<p class="title">
								<button type="submit" class="button is-success is-pulled-right">
									Update
								</button>
								User's Groups
							</p>
							@if (userGroupsCount())
								@foreach (userGroups() as $group)
									<p class="control">
										<label class="checkbox">
											<input @if ($user->inGroup($group->id)) checked @endif type="checkbox" name="group_id[]" value="{{ $group->id }}" />
											{{ $group->name }}
										</label>
									</p>
								@endforeach
							@else
								<p><span class="is-error">No registered user groups.</span></p>
							@endif
						</form>
					</article>
					<article class="tile is-child box">
						<form role="form" method="POST" action="{{ route('users.update-roles', $user->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}
							<p class="title">
								<button type="submit" class="button is-success is-pulled-right">
									Update
								</button>
								User's Roles
							</p>
							@if (userGroupsCount())
								@foreach (branchRoles() as $role)
									<p class="control">
										<label class="checkbox">
											<input @if ($user->hasRole($role->id)) checked @endif type="checkbox" name="role_id[]" value="{{ $role->id }}" />
											{{ $role->name }} <small>({{ $role->branch->name }})</small>
										</label>
									</p>
								@endforeach
							@else
								<p><span class="is-error">No registered user groups.</span></p>
							@endif
						</form>
					</article>

					<article class="tile is-child box">
						<p class="title">Contact User</p>

						<form role="form" method="POST" action="{{ route('users.send-email', $user->id) }}" enctype="multipart/form-data">
							{{ csrf_field() }}

							<div class="field">
								<label class="label" for="subject">Subject</label>
								<p class="control">
									<input type="text" name="subject" class="input" />
								</p>
							</div>

							<div class="field">
								<label class="label" for="body">Body</label>
								<p class="control">
									<textarea name="body" class="textarea"></textarea>
								</p>
							</div>

							<div class="field">
								<label class="label" for="attachments">Attachments</label>
								<p class="control">
									<input type="file" name="attachments[]" multiple class="input" />
								</p>
							</div>

							<button type="submit" class="button is-primary">
								Send E-Mail
							</button>

						</form>

					</article>
				</div>
			</div>

		</div>
	</section>

@endsection

@push('footer_scripts')
	<script>
		$('#updateEmailForm').hide();
		$('#updatePasswordForm').hide();
		$('#updatePhonesForm').hide();

		$('.toggle-update-email').click(function() {
			$('#updatePasswordForm').hide('slow');
			$('#updateEmailForm').toggle('slow');
			$('#updatePhonesForm').hide();
		});

		$('.toggle-update-password').click(function() {
			$('#updateEmailForm').hide('slow');
			$('#updatePasswordForm').toggle('slow');
			$('#updatePhonesForm').hide();
		});

		$('.toggle-update-phones').click(function() {
			$('#updateEmailForm').hide('slow');
			$('#updatePasswordForm').hide('slow');
			$('#updatePhonesForm').toggle('slow');
		});
	</script>
@endpush