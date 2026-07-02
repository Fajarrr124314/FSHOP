<?php

namespace App\Livewire\Topup;

use App\Models\Game;
use App\Models\GamePackage;
use App\Models\Order;
use App\Services\DokuService;
use Livewire\Component;
use Illuminate\Support\Str;

class TopupList extends Component
{
    public $activeTab = 'all';

    public function setTab($category)
    {
        $this->activeTab = $category;
    }

    public function render()
    {
        $query = Game::with('packages');
        
        if ($this->activeTab !== 'all') {
            $query->where('category', $this->activeTab);
        }

        return view('livewire.topup.topup-list', [
            'games' => $query->get()
        ])->layout('components.layouts.app');
    }
}

