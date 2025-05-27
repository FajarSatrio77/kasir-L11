<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ActivityLog;
use Livewire\WithPagination;

class ActivityLogs extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function __invoke()
    {
        return $this->render();
    }

    public function render()
    {
        $logs = ActivityLog::query()
            ->when($this->search, function($query) {
                $query->where(function($query) {
                    $query->where('description', 'like', '%' . $this->search . '%')
                        ->orWhere('causer_type', 'like', '%' . $this->search . '%')
                        ->orWhere('subject_type', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->date, function($query) {
                $query->whereDate('created_at', $this->date);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.activity-logs', [
            'logs' => $logs
        ]);
    }
} 