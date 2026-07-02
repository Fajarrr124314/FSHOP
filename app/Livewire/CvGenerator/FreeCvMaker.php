<?php

namespace App\Livewire\CvGenerator;

use Livewire\Component;
use Livewire\WithFileUploads;

class FreeCvMaker extends Component
{
    use WithFileUploads;

    public $step = 'choose'; // 'choose' or 'edit'
    public $selectedTemplate = 'ats'; // 'ats' or 'creative'
    public $creativeTheme = 'purple'; // 'purple', 'blue', 'emerald', 'sunset'

    public $photo; // Uploaded file
    public $photoUrl = 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80';

    // Personal Info
    public $fullName = 'FAJAR NUR FARRIJAL';
    public $jobTitle = 'TEKNIK KOMPUTER JARINGAN, DESIGNER, UI/UX DESIGNER, FRONT-END DEVELOPER';
    public $email = 'fajarnf77@gmail.com';
    public $phone = '0895 8063 17711';
    public $address = 'Karawang, Jawa Barat';

    // Social & Portfolio
    public $portfolioUrl = 'https://fajarportfolio.veroku.com/';
    public $socialLinkedin = 'linkedin.com/in/fajar-nur-farrijal';
    public $socialGithub = 'github.com/fajarnf77';
    public $socialInstagram = 'instagram.com/fajarnf77';
    public $socialFacebook = 'facebook.com/fajarnurfarrijal';

    // CV Content Sections
    public $summary = 'Perkenalkan saya Fajar Nur Farrijal, seorang mahasiswa Teknik Informatika di Horizon University Indonesia Karawang, lahir di Bandung, 26 April 2001, umur 24 tahun dan saat ini tinggal di kota Karawang';
    public $experience = "IT Support - CV Innovation Technology (Purwakarta)\nMaintenance khusus printer & komputer | 2017 - 2018\n• Memperbaiki komputer & printer yang bermasalah serta melakukan maintenance berkala.\n\nIT Support - Pemagangan (Purwakarta)\nMengelola jaringan komputer | 2018 - 2019\n• Mengelola jaringan komputer di seluruh sekolah SMK & SMA di Purwakarta dalam mengembangkan ujian berbasis komputer\n\nDesain Grafis - PT Akur Pratama (Yogya Group), Cabang Toserba Yogya Grand Karawang\nDesign Grafis & Digital Marketing | 2019 - 2024\n• Bertugas sebagai design grafis sekaligus digital marketing untuk meningkatkan grafik konsumen melalui media sosial.";
    public $education = "SMK YPK Purwakarta - Teknik Komputer & Jaringan\nHorizon University Indonesia, Karawang - S1 Informatika - Semester 7";
    public $skills = "Microsoft Office, Maintenance komputer & printer, Jaringan Komputer, Design Grafis (Adobe Ai, Psd, Corel draw), Design UI/UX (Figma), Pemrograman Web PHP, Pemrograman Mobile Dart, Flutter";

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:3072', // Max 3MB
        ]);

        $this->photoUrl = $this->photo->temporaryUrl();
    }

    public function selectTemplate($template)
    {
        $this->selectedTemplate = $template;
        $this->step = 'edit';
    }

    public function switchTemplate()
    {
        $this->step = 'choose';
    }

    public function setTheme($theme)
    {
        $this->creativeTheme = $theme;
    }

    public function resetCvData()
    {
        $this->fullName = '';
        $this->jobTitle = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->summary = '';
        $this->experience = '';
        $this->education = '';
        $this->skills = '';
        $this->socialLinkedin = '';
        $this->socialGithub = '';
        $this->socialInstagram = '';
        $this->socialFacebook = '';
        $this->portfolioUrl = '';
        $this->photoUrl = '';
    }

    public function render()
    {
        return view('livewire.cv-generator.free-cv-maker')->layout('components.layouts.app');
    }
}


