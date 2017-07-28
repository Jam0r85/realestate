@component('mail::message')
# Hello!

This is just a quick email to let you know that the latest rental statement for the property below is on it's way to you by post.

<b>{{ $statement->tenancy->property->name }}</b>

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}
@endcomponent