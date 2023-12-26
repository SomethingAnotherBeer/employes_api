<?php
namespace App\Exceptions\User;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserAlreadyExistsException extends ConflictHttpException
{

}