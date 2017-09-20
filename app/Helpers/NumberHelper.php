<?php

function currency($amount = null)
{
	return $amount;
	if (is_null($amount)) {
		$amount = 0;
	}
	
	setlocale(LC_MONETARY, 'en_GB');
	// return '£' . money_format('%!n', $amount);
	return '£' . number_format($amount, 2);
}