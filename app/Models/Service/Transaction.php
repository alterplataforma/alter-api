<?php

namespace App\Models\Service;

use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';


    // usando factory
    protected static function newFactory(): TransactionFactory {
        return TransactionFactory::new();
    }
}
