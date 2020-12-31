<?php

namespace Finalsmile6868\Kuangshi\Events;

use Finalsmile6868\Kuangshi\Models\KuangshiEventRecord;
use Illuminate\Queue\SerializesModels;

class KuangshiEvent
{
    use SerializesModels;

    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(KuangshiEventRecord $record)
    {
        $this->data = $record->toArray();
    }

    
}
