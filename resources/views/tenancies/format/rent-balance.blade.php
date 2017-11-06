<span class="@if ($tenancy->getRentBalance() < 0) text-danger @elseif ($tenancy->getRentBalance() > 0) text-success @endif">
	{{ currency($tenancy->getRentBalance()) }}
</span>