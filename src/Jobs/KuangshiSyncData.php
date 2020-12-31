<?php

namespace Finalsmile6868\Kuangshi\Jobs;

use Finalsmile6868\Kuangshi\Kuangshi;
use Finalsmile6868\Kuangshi\Models\KuangshiPerson;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class KuangshiSyncData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Kuangshi $kuangshi)
    {
        $page_size = 20;
        $page_num = 1;
        do {            
            $data = $kuangshi->getPersonList($this->type, $page_num, $page_size);            
            foreach ($data['list'] as $item) {
                $item['groupList'] = json_encode($item['groupList']);
                $person = KuangshiPerson::where('uuid', $item['uuid'])->first();
                if ($person) {
                    $person->update($item);
                } else {
                    KuangshiPerson::create($item);
                }
            }
            $page_num++;            
        } while ($data['pageSize'] == 20);
    }
}
