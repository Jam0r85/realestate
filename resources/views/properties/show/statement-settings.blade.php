@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('properties.show', $property->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $property->name }}</h1>
			<h2 class="subtitle">Statement Settings</h2>

		</div>
	</section>

	<form role="form" method="POST" action="{{ route('properties.update-statement-settings', $property->id) }}">
		{{ csrf_field() }}

		<section class="section">
			<div class="container">

				<div class="card mb-2">
					<header class="card-header">
						<p class="card-header-title">
							Default Bank Account
						</p>
					</header>
					<div class="card-content">
						<div class="content">

							<p>
								Select a bank account to be assigned to this property and to where all landlord payments from rental statements should be sent. Note that only bank accounts which are linked to the owners of the property can be chosen.
							</p>

						</div>
						<div class="field">
							<label class="label" for="bank_account_id">Bank Account</label>
							<div class="control">
								<span class="select is-fullwidth">
									<select name="bank_account_id">
										<option value="0">None</option>
										@foreach (bank_accounts($property->owners->pluck('id')->toArray()) as $account)
											<option @if ($property->bank_account_id == $account->id) selected @endif value="{{ $account->id }}">{{ $account->name }}</option>
										@endforeach
									</select>
								</span>
							</div>
						</div>

					</div>
				</div>

				<div class="card mb-2">
					<header class="card-header">
						<p class="card-header-title">
							Statement Send Method
						</p>
					</header>
					<div class="card-content">
						<div class="content">

							<p>
								Choose how the landlord wishes to receive their rental statements. Note that the landlord can update this setting themselves.
							</p>

							<div class="field">
								<label class="label" for="sending_method">Sending Method</label>
								<p class="control is-expanded">
									<span class="select is-fullwidth">
										<select name="sending_method">
											<option @if ($property->hasSetting('post_rental_statement')) selected @endif value="post">By Post</option>
											<option @if (!$property->hasSetting('post_rental_statement')) selected @endif value="email">By E-Mail</option>
										</select>
									</span>
								</p>
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

			</div>
		</section>

	</form>

@endsection