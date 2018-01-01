@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Uploaded</th>
		<th>Name</th>
		<th>Parent</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($documents as $document)
			<tr>
				<td>{{ $document->present()->status }}</td>
				<td>{{ date_formatted($document->created_at) }}</td>
				<td>{{ $document->name }}</td>
				<td>
					<span class="badge badge-secondary">
						{{ $document->present()->parentBadge }}
					</span>
					{{ $document->present()->parentName }}
				</td>
				<td class="text-right">
					@include('partials.document-download-button', ['path' => $document->path])
					<a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning btn-sm">
						@icon('edit')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent