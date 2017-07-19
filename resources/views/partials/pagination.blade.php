@if ($collection instanceof \Illuminate\Pagination\LengthAwarePaginator)
	{{ $collection->links('vendor.pagination.bulma') }}
@endif