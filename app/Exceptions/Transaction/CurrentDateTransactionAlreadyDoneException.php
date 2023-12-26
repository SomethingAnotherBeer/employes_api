<?php
namespace App\Exceptions\Transaction;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class CurrentDateTransactionAlreadyDoneException extends ConflictHttpException
{
    
}