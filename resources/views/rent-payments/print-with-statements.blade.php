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
                Rent Payments Received (with Statements)
            @endcomponent

        </div>

    @endcomponent

    @component('partials.bootstrap.section-with-container')

        @component('partials.table')
            @slot('header')
                <th>Date</th>
                <th>Amount</th>
                <th>Name</th>                
                <th>Other</th>
                <th class="text-right">Balance</th>
            @endslot
            @slot('body')
                @foreach ($merged as $item)
                    <tr>
                        <td>{{ date_formatted($item->created_at) }}</td>
                        <td>{{ currency($item->amount) }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->other }}</td>
                        <td class="text-right">
                            {{ currency($item->balance) }}
                        </td>
                    </tr>
                @endforeach
            @endslot
        @endcomponent

    @endcomponent

</body>
</html>