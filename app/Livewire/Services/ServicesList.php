<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;

class ServicesList extends Component
{
    public $activeFilter = 'all';

    public function setFilter($category)
    {
        $this->activeFilter = $category;
    }

    public function render()
    {
        $query = Service::query();
        
        if ($this->activeFilter !== 'all') {
            $query->where('category', $this->activeFilter);
        }

        return view('livewire.services.services-list', [
            'services' => $query->get()
        ])->layout('components.layouts.app');
    }

}
