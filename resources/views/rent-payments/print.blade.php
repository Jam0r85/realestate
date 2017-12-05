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

    @component('partials.bootstrap.section-with-container')

        <div class="page-title">

            @component('partials.header')
                {{ $tenancy->present()->name }}
            @endcomponent

            @component('partials.sub-header')
                Rent Payments Received
            @endcomponent

        </div>

    @endcomponent

    @component('partials.bootstrap.section-with-container')

        @component('partials.table')
            @slot('header')
                <th>Date</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Recorded By</th>
                <th>Note</th>
            @endslot
            @slot('body')
                @foreach ($tenancy->rent_payments as $payment)
                    <tr>
                        <td>
                            <a href="{{ route('payments.show', $payment->id) }}" title="Payment #{{ $payment->id }}">
                                {{ date_formatted($payment->created_at) }}
                            </a>
                        </td>
                        <td>{{ currency($payment->amount) }}</td>
                        <td>{{ $payment->method->name }}</td>
                        <td>{{ $payment->owner->name }}</td>
                        <td>
                            <small>{{ $payment->note }}</small>
                        </td>
                    </tr>
                @endforeach
            @endslot
        @endcomponent

    @endcomponent

</body>
</html>