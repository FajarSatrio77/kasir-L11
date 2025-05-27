<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait HasActivityLogs
{
    public static function bootHasActivityLogs()
    {
        static::created(function ($model) {
            $model->logActivity('created');
        });

        static::updated(function ($model) {
            $model->logActivity('updated');
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted');
        });
    }

    public function logActivity($action)
    {
        if (!auth()->check()) {
            return;
        }

        $description = $this->getActivityDescription($action);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => $description,
            'subject_type' => get_class($this),
            'subject_id' => $this->id,
            'causer_type' => get_class(auth()->user()),
            'causer_id' => auth()->id(),
            'properties' => [
                'old' => $this->getOriginal(),
                'new' => $this->getChanges(),
                'action' => $action
            ]
        ]);
    }

    protected function getActivityDescription($action)
    {
        $modelName = class_basename($this);
        
        switch ($action) {
            case 'created':
                return "Membuat {$modelName} baru";
            case 'updated':
                return "Memperbarui {$modelName}";
            case 'deleted':
                return "Menghapus {$modelName}";
            default:
                return "Melakukan aksi {$action} pada {$modelName}";
        }
    }
} 