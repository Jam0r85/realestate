<?php

namespace App\Presenters;

class StatementPaymentPresenter extends BasePresenter
{    
    /**
     * @return string
     */
    public function name()
    {
        if (plural_from_model($this->parent) == 'invoices') {
            return 'Invoice Payment';
        }

        if (plural_from_model($this->parent) == 'expenses') {
            return 'Expense Payment';
        }

        if (!plural_from_model($this->parent)) {
            return 'Landlord Payment';
        }
    }

    /**
     * @return string
     */
    public function method()
    {
        if ($this->bank_account) {
            return 'BACS: ' . $this->bank_account->account_name;
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
        if (model_name($this->parent) == 'Invoice') {
            return $this->parent->present()->name;
        }
    }

    /**
     * @return string
     */
    public function userBadges()
    {
        if (count($this->users)) {
            foreach ($this->users as $user) {
                $names[] = $this->badge($user->present()->fullName);
            }
        }

        if (isset($names) && count($names)) {
            return implode(' ', $names);
        }
    }

    /**
     * @return  array
     */
    public function relatedUserIds()
    {
        // Get the owners of the property
        $owners = $this->statement->users->pluck('id')->toArray();

        // Get the users of this payment
        $users = $this->users->pluck('id')->toArray();

        return array_merge($owners, $users);
    }
}