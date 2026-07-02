<?php

namespace App\Livewire\Navbar;

use Livewire\Component;
use Livewire\Attributes\On;

class Header extends Component
{
    public $isMobileMenuOpen = false;
    public $activeNav = 'home';

    protected $listeners = [
        'nav-scrolled' => 'onNavScrolled'
    ];

    public function mount()
    {
        //
    }

    #[On('nav-scrolled')]
    public function onNavScrolled($section)
    {
        $this->activeNav = $section;
    }

    public function toggleMobileMenu()
    {
        $this->isMobileMenuOpen = !$this->isMobileMenuOpen;
    }

    public function setActiveNav($nav)
    {
        $this->activeNav = $nav;
        $this->isMobileMenuOpen = false;
    }

    public function render()
    {
        $routeName = request()->route()?->getName();
        if ($routeName) {
            $this->activeNav = match($routeName) {
                'home' => 'home',
                'services' => 'services',
                'topup' => 'topup',
                'cv-maker' => 'cv-maker',
                'cover-letter' => 'cover-letter',
                default => 'home'
            };
        }
        return view('livewire.navbar.header');
    }

}
