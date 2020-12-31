<?php

namespace Finalsmile6868\Kuangshi\Models;

use Illuminate\Database\Eloquent\Model;

class KuangshiPerson extends Model{

   protected $table = 'kuangshi_persons'; 

   const TYPE_EMPLOYEE = 1;//员工

   protected $fillable = [
    'birthday',      
    'cardNum',    
    'code',          
    'departmentName',
    'departmentUuid',
    'email',
    'entryTime',    
    'ext',
    'groupList',
    'groupName',
    'groupUuid',
    'identifyNum',   
    'imageUrl',
    'name',
    'password',      
    'phone',
    'position',
    'sex',
    'type',
    'uuid',
    'visitEndTime',
    'visitReason',
    'visitStartTime',
    'visitedName',
    'visitedStatus',
    'visitedUuid',
   ];
}