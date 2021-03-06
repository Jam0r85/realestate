<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ get_setting('company_name', config('app.name', 'Laravel')) }}</title>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>

	<section class="section">
		<div class="container">

			@foreach ($unsent_payments as $name => $payments)

				<div class="card mb-3">
					<div class="card-header">
						{{ ucwords($name) }} {{ money_formatted($payments->sum('amount')) }}
					</div>

					@include('statement-payments.partials.'.$name.'-table')
				</div>

			@endforeach

		</div>
	</section>

</body>
</html>