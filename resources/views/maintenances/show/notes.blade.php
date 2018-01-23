@each('notes.partials.note', $notes = $issue->notes()->with('user')->paginate(), 'note')

@include('partials.pagination', ['collection' => $notes])