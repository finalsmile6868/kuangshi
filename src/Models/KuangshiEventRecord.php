<?php

namespace Finalsmile6868\Kuangshi\Models;

use Illuminate\Database\Eloquent\Model;

class KuangshiEventRecord extends Model
{
    protected $table = 'kuangshi_event_records';

    protected $fillable = [
        'id',
        'custom',
        'deviceLocation',
        'deviceName',
        'deviceUuid',
        'record_id',
        'livenessScore',
        'livenessType',
        'maskType',
        'passTime',
        'passType',
        'personCode',
        'personImageUrl',
        'personName',    
        'personType',    
        'personUuid',
        'recognitionScore',
        'recognitionType',
        'snCode',
        'snapshotUrl',
        'temperature',
        'temperatureType',
        'verificationMode',
        'type',
    ];
}
