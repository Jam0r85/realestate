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
     <link href="{{ mix('css/all.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>

	<section class="section">
		<div class="container">

            <table class="table table-striped table-responsive">
                <thead>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Method</th>
                </thead>
                <tbody>
                    @foreach ($tenancy->rent_payments as $payment)
                        <tr>
                            <td>
                                <a href="{{ route('payments.show', $payment->id) }}" title="Payment #{{ $payment->id }}">
                                    {{ date_formatted($payment->created_at) }}
                                </a>
                            </td>
                            <td>{{ currency($payment->amount) }}</td>
                            <td>{{ $payment->method->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

		</div>
	</section>

</body>
</html>