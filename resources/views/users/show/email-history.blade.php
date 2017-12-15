@include('emails.partials.emails-table', ['emails' => $user->emails])

@include('partials.pagination', ['collection' => $user->emails])