<?php

namespace App\Livewire\Widgets;

use Livewire\Component;

class SpaceWeather extends Component
{
    public $status = 'Terhubung ke Satelit Weather FSHOP';
    public $location = 'Karawang West, Indonesia';
    public $temperature = '29°C Orbit Clear';

    public function render()
    {
        return view('livewire.widgets.space-weather');
    }
}
