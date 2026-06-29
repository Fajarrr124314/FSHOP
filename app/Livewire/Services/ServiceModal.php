<?php

namespace App\Livewire\Services;

use Livewire\Component;

class ServiceModal extends Component
{
    public $isOpen = false;
    public $service = null;

    protected $listeners = ['showServiceModal' => 'openModal'];

    public function openModal($service)
    {
        $this->service = $service;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->dispatch('closeServiceModal');
    }

    public function render()
    {
        return view('livewire.services.service-modal');
    }
}
