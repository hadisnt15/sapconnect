<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    public static function log($action, $module, $refId, $refId2, $desc = null, $properties = null)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'module' => $module,
            'action' => $action,
            'ref_id' => $refId,
            'ref_id_2' => $refId2,
            'description' => $desc,
            'properties' => $properties,
        ]);
    }
}
