<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Schedule;
use App\Models\Transaction;

class ScheduleObserver
{
    /**
     * Handle the Schedule "created" event.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return void
     */
    public function created(Schedule $schedule)
    {

        // dd($schedule);

        $productsList = $schedule->products; 
        $products     = Product::whereIn('id', json_encode($schedule->products));
        

        // !!! TERMINAR
        

        // Transaction::create([
        //     'products' => $schedule->products,
        //     'total_price' => '1000',
        //     'payment_method' => 'pix',

        // ]);
    }

    /**
     * Handle the Schedule "updated" event.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return void
     */
    public function updated(Schedule $schedule)
    {
        //
    }

    /**
     * Handle the Schedule "deleted" event.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return void
     */
    public function deleted(Schedule $schedule)
    {
        //
    }

    /**
     * Handle the Schedule "restored" event.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return void
     */
    public function restored(Schedule $schedule)
    {
        //
    }

    /**
     * Handle the Schedule "force deleted" event.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return void
     */
    public function forceDeleted(Schedule $schedule)
    {
        //
    }
}
