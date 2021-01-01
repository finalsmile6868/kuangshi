<?php

namespace Finalsmile6868\Kuangshi\Listeners;

use App\Events\KuangshiEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class KuangshiListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  KuangshiEvent  $event
     * @return void
     */
    public function handle(KuangshiEvent $event)
    {
        $data = $event->data;
        Log::info('kuangshi:event:',[$data]); 
    }
}
