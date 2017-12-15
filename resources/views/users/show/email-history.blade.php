@include('emails.partials.emails-table', ['emails' => $user->emails()->paginate()])

@include('partials.pagination', ['collection' => $user->emails()->paginate()])