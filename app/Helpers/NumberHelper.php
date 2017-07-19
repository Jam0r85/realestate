<?php

function currency($amount = null)
{
	setlocale(LC_MONETARY, app()->getLocale());
	return money_format('%.2n', $amount);
}