<span class="@if ($tenancy->present()->rentBalance < 0) text-danger @elseif ($tenancy->present()->rentBalance > 0) text-success @endif">
	{{ currency($tenancy->present()->rentBalance) }}
</span>