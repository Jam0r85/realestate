<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatementExpense extends Model
{
    public $table = 'expense_statement';

    public $fillable = ['expense_id','statement_id','amount'];
}
