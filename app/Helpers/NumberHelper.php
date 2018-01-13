<?php

use App\TaxRate;
use App\Tenancy;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

/**
 * Return the money formatted depending on the country and currency.
 */
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

/**
 * Turn pence into pounds
 */
if (!function_exists('pence_to_pounds')) {
	function pence_to_pounds($pence = 0) {
		return $pence / 100;
	}
}

/**
 * Turn pounds into pence
 */
if (!function_exists('pounds_to_pence')) {
	function pounds_to_pence($pounds = 0) {
		return $pounds * 100;
	}
}

/**
 * Calculate the tax amount for a given amount
 */
if (!function_exists('calculateTax')) {
	function calculateTax($amount, TaxRate $tax = null) {

		if (! $tax) {
			return 0;
		}

		if (! $tax->amount) {
			return 0;
		}

		return round($amount * ($tax->amount / 100));
	}
}

/**
 * Calculate the service charge for a tenancy.
 */
if (!function_exists('calculateServiceCharge')) {
	function calculateServiceCharge(Tenancy $tenancy, $amount = 0, $fee = 0)
	{
		// Tenancy does not have a service set
		if (! $tenancy->service) {
			return 0;
		}

		if ($tenancy->service->charge) {
			if ($tenancy->service->is_percent) {
				$fee = $tenancy->service->charge / 100;
				$fee_type = 'percent';
			} else {
				$fee = $tenancy->service->charge;
				$fee_type = 'fixed';
			}
		}

		if ($tenancy->currentRent) {
			$amount = $tenancy->currentRent->amount;
		}

		// Remember to include any percentage service discounts before working out the charge
		if (count($tenancy->serviceDiscounts)) {
			foreach ($tenancy->serviceDiscounts as $discount) {
				$fee = $fee - $discount->amount;
			}
		}

		$charge = $amount * $fee;

		return round($charge);
	}
}