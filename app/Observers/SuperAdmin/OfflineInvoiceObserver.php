<?php

namespace App\Observers\SuperAdmin;

use App\Models\SuperAdmin\OfflineInvoice;

class OfflineInvoiceObserver
{

    public function saving(OfflineInvoice $invoice)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $invoice->company_id = company()->id;
        }
    }

}
