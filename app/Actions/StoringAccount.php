<?php

namespace App\Actions;

use App\Models\Account;

class StoringAccount
{
    static public function  make(Account $account)
    {
        switch ($account->status_code) {
            case 'value':
                # code...
                break;

            default:
                # code...
                break;
        }
    }
}
