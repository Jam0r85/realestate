@extends('layouts.app')

@section('content')

	<div class="container">

		<div class="row">
			<div class="col-sm-12 col-lg-3 pr-lg-5">

				<div class="nav flex-column nav-pills">
					<a class="nav-link {{ Menu::activeRoute('settings.general', 'active') }}" href="{{ route('settings.general') }}" title="General Settings">
						General Settings
					</a>
					<a class="nav-link {{ Menu::activeRoute('settings.invoice', 'active') }}" href="{{ route('settings.invoice', 'invoice') }}" title="Invoice Settings">
						Invoice Settings
					</a>
					<a class="nav-link {{ Menu::activeRoutes(['settings.tax-rates','settings.edit-tax-rate'], 'active') }}" href="{{ route('settings.tax-rates') }}" title="Tax Rates">
						Tax Rates
					</a>
					<a class="nav-link {{ Menu::activeRoute('settings.logo', 'active') }}" href="{{ route('settings.logo') }}" title="Business Logo">
						Business Logo
					</a>
				</div>

			</div>
			<div class="col-sm-12 col-lg-9">

				<hr class="d-lg-none my-3" />

				@yield('settings-content')

			</div>
		</div>

	</div>

@endsection