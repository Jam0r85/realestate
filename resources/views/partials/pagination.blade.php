@if ($collection instanceof \Illuminate\Pagination\LengthAwarePaginator)
	<hr />
	{{ $collection->links('vendor.pagination.bootstrap-4') }}
@endif