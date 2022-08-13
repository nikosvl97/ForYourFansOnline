<?php

namespace App\Observers;

use App\Model\Transaction;

class TransactionsObserver
{
    /**
     * Listen to the Transaction deleting event.
     *
     * @param  \App\Model\Transaction  $transaction
     * @return void
     */
    public function deleting(Transaction $transaction)
    {
        // removes invoice along with transaction
        if ($transaction->invoice()) {
            $transaction->invoice()->delete();
        }
    }
}
