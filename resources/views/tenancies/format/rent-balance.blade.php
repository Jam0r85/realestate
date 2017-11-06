<span class="@if ($tenancy->getRentBalance() < 0) text-danger @elseif ($tenancy->rent_balance > 0) text-success @endif">
	{{ currency($tenancy->getRentBalance()) }}
</span>