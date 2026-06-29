<?php

namespace App\Livewire\Navbar;

use Livewire\Component;
use Livewire\Attributes\On;

class Header extends Component
{
    public $isMobileMenuOpen = false;
    public $activeNav = 'home';

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
        return view('livewire.navbar.header');
    }
}
