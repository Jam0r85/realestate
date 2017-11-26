@if ($collection instanceof \Illuminate\Pagination\LengthAwarePaginator)
	@if (count($collection))
		<hr />
		{{ $collection->links('vendor.pagination.bootstrap-4') }}
	@endif
@endif