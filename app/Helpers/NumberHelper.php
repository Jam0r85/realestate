<?php

function currency($amount = null)
{
	setlocale(LC_MONETARY, 'en_GB');
	return '£' . money_format('%!n', $amount);
}