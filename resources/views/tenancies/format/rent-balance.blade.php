<span class="@if ($tenancy->rent_balance < 0) text-danger @elseif ($tenancy->rent_balance > 0) text-success @endif">
	{{ currency($tenancy->rent_balance) }}
</span>