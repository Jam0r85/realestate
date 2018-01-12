<?php

namespace App\Console\Commands;

use App\AppearancePrice;
use App\Deposit;
use App\Expense;
use App\Invoice;
use App\InvoiceItem;
use App\Payment;
use App\Statement;
use App\StatementExpense;
use App\StatementPayment;
use App\TaxBand;
use App\Tenancy;
use App\TenancyRent;
use Illuminate\Console\Command;

class FormatPoundsToPence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'format:pounds-to-pence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes pounds to pence';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Invoices
        if (get_setting('invoice_pounds_to_pence')) {
            $this->info('Invoices already converted');
        } else {
            $records = Invoice::all();

            foreach ($records as $record) {
                $record->update([
                    'net' => $record->net * 100,
                    'tax' => $record->tax * 100,
                    'total' => $record->total * 100,
                    'balance' => $record->balance * 100
                ]);
            }

            $this->info('Invoices converted');
            set_setting('invoice_pounds_to_pence', 'true');
        }

        // Invoice Items
        if (get_setting('invoice_item_pounds_to_pence')) {
            $this->info('Invoice items already converted');
        } else {
            $records = InvoiceItem::all();

            foreach ($records as $record) {
                $record->update([
                    'amount' => $record->amount * 100
                ]);
            }

            $this->info('Invoice Items converted');
            set_setting('invoice_item_pounds_to_pence', 'true');
        }

        // Statement Payments
        if (get_setting('statement_payment_pounds_to_pence')) {
            $this->info('Statement payments already converted');
        } else {
            $records = StatementPayment::all();

            foreach ($records as $record) {
                $record->update([
                    'amount' => $record->amount * 100
                ]);
            }

            $this->info('Statement Payments converted');
            set_setting('statement_payment_pounds_to_pence', 'true');
        }

        // Statements
        if (get_setting('statement_pounds_to_pence')) {
            $this->info('Statements already converted');
        } else {
            $records = Statement::all();

            foreach ($records as $record) {
                $record->update([
                    'amount' => $record->amount * 100
                ]);
            }

            $this->info('Statements converted');
            set_setting('statement_pounds_to_pence', 'true');
        }

        // Tax Bands
        if (get_setting('tax_band_pounds_to_pence')) {
            $this->info('Tax Bands already converted');
        } else {
            $records = TaxBand::all();

            foreach ($records as $record) {
                $record->update([
                    'amount' => $record->amount * 100
                ]);
            }

            $this->info('Tax Bands converted');
            set_setting('tax_band_pounds_to_pence', 'true');
        }

        // Tenancies
        if (get_setting('tenancy_pounds_to_pence')) {
            $this->info('Tenancies already converted');
        } else {
            $records = Tenancy::all();

            foreach ($records as $record) {
                $record->update([
                    'rent_balance' => $record->rent_balance * 100
                ]);
            }

            $this->info('Tenancies converted');
            set_setting('tenancy_pounds_to_pence', 'true');
        }

        // Tenancy Rents
        if (get_setting('tenancy_rent_pounds_to_pence')) {
            $this->info('Tenancy Rents already converted');
        } else {
            $records = TenancyRent::all();

            foreach ($records as $record) {
                $record->update([
                    'amount' => $record->amount * 100
                ]);
            }

            $this->info('Tenancy Rents converted');
            set_setting('tenancy_rent_pounds_to_pence', 'true');
        }

        // Appearance Prices
        if (get_setting('appearance_price_pounds_to_pence')) {
            $this->info('Appearance Prices already converted');
        } else {
            $records = AppearancePrice::all();

            foreach ($records as $record) {
                $record->update([
                    'amount' => $record->amount * 100
                ]);
            }

            $this->info('Appearance Prices converted');
            set_setting('appearance_price_pounds_to_pence', 'true');
        }

        // Deposits
        if (get_setting('deposit_pounds_to_pence')) {
            $this->info('Deposits already converted');
        } else {
            $records = Deposit::all();

            foreach ($records as $record) {
                $record->update([
                    'amount' => $record->amount * 100,
                    'balance' => $record->balance * 100
                ]);
            }

            $this->info('Deposits converted');
            set_setting('deposit_pounds_to_pence', 'true');
        }

        // Statement Expenses
        if (get_setting('statement_expense_pounds_to_pence')) {
            $this->info('Statement Expenses already converted');
        } else {
            $records = Statement::all();

            foreach ($records as $record) {
                if (count($record->expenses)) {
                    foreach ($record->expenses as $expense) {
                        $record->expenses()->updateExistingPivot($expense->id, ['amount' => $expense->pivot->amount * 100]);
                    }
                }
            }

            $this->info('Statement Expenses converted');
            set_setting('statement_expense_pounds_to_pence', 'true');
        }

        // Expenses
        if (get_setting('expense_pounds_to_pence')) {
            $this->info('Expenses already converted');
        } else {
            $records = Expense::all();

            foreach ($records as $record) {
                $record->update([
                    'cost' => $record->cost * 100,
                    'balance' => $record->balance * 100
                ]);
            }

            $this->info('Expenses converted');
            set_setting('expense_pounds_to_pence', 'true');
        }

        // Payments
        if (get_setting('payment_pounds_to_pence')) {
            $this->info('Payments already converted');
        } else {
            $records = Payment::all();

            foreach ($records as $record) {
                $record->update([
                    'amount' => $record->amount * 100
                ]);
            }

            $this->info('Payments converted');
            set_setting('payment_pounds_to_pence', 'true');
        }
    }
}
