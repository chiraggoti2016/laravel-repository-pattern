<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\PartnerCustomer;

class CustomerObserver
{
    /**
     * Handle the Customer "creating" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function creating(Customer $customer)
    {
        $customer->added_by = auth()->user()->id;
        return $customer;
    }

    /**
     * Handle the Customer "created" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        $user = auth()->user() ?? null;
        $partner = $user ? $user->partner : null;
        if($partner) {
            PartnerCustomer::create([
                'partner_id'    => $partner->id,
                'customer_id'   => $customer->id,
            ]);    
        }
        return $customer;
    }

}
