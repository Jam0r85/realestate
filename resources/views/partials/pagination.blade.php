@if ($collection instanceof \Illuminate\Pagination\LengthAwarePaginator)
	{{ $collection->links('vendor.pagination.bootstrap-4') }}
@endif