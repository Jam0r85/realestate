<?php

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

if (!function_exists('money_formatted')) {
	function money_formatted($amount = 0)
	{
		$country = Countries::where('name.common', get_setting('default_country', 'United Kingdom'))->first();
		$currencyCode = $country->currency[0]['ISO4217Code'];

		$money = new Money ($amount, new Currency ($currencyCode));
		$currencies = new ISOCurrencies();

		$numberFormatter = new \NumberFormatter('en_GB', \NumberFormatter::CURRENCY);
		$moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

		return $moneyFormatter->format($money);
	}
}

if (!function_exists('pence_to_pounds')) {
	function pence_to_pounds($pence = 0) {
		return $pence / 100;
	}
}

if (!function_exists('pounds_to_pence')) {
	function pounds_to_pence($pounds = 0) {
		return $pounds * 100;
	}
}