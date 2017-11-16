<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class StatementPaymentPresenter extends Presenter
{
    /**
     * @return string
     */
    public function name()
    {
        if ($this->parent_type == 'invoices') {
            return 'Invoice Payment';
        } elseif ($this->parent_type == 'expenses') {
            return 'Expense Payment';
        } else {
            return 'Landlord Payment';
        }
    }

    /**
     * @return string
     */
    public function groupName()
    {
        if (!$this->parent_type) {
            $this->parent_type = 'landlord';
        }

        return str_singular($this->parent_type);
    }

    /**
     * @return string
     */
    public function method()
    {
        if ($this->bank_account) {
            return $this->bank_account->account_name;
        } elseif ($this->parent_type == 'invoices') {
            return 'n/a';
        } else {
            return 'Cash or Cheque';
        }
    }

    /**
     * @return string
     */
    public function tenancyName()
    {
        return $this->statement->tenancy->present()->name;
    }

    /**
     * @return string
     */
    public function propertyName()
    {
        return $this->statement->tenancy->property->present()->shortAddress;
    }

    /**
     * @return string
     */
    public function statementName()
    {
        return 'Statement #' . $this->statement_id;
    }

    /**
     * @return string
     */
    public function invoiceName()
    {
        if ($this->parent_type == 'invoices') {
            return $this->parent->present()->name;
        }
    }

    /**
     * @return string
     */
    public function expenseName()
    {
        if ($this->parent_type == 'expenses') {
            $name = $this->parent->name;

            if ($this->parent->contractor) {
                $name .= '<br />' . $this->parent->contractor->present()->fullName;
            }

            return $name;
        }
    }

    /**
     * @return string
     */
    public function status()
    {
        if ($this->sent_at) {
            return 'Sent';
        } else {
            return 'Unsent';
        }
    }
}