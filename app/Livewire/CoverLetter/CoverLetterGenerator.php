<?php

namespace App\Livewire\CoverLetter;

use Livewire\Component;

class CoverLetterGenerator extends Component
{
    public $fullName = '';
    public $email = '';
    public $phone = '';
    public $targetCompany = '';
    public $targetPosition = '';
    public $experienceYears = '1-2 tahun';
    public $keySkills = '';
    public $workTone = 'profesional';
    public $generatedLetter = '';
    public $isGenerated = false;

    public function generateLetter()
    {
        $this->validate([
            'fullName' => 'required|min:3',
            'targetCompany' => 'required',
            'targetPosition' => 'required',
        ], [
            'fullName.required' => 'Nama lengkap wajib diisi.',
            'targetCompany.required' => 'Nama perusahaan tujuan wajib diisi.',
            'targetPosition.required' => 'Posisi yang dilamar wajib diisi.',
        ]);

        $dateToday = date('d F Y');
        $name = $this->fullName ?: '[Nama Anda]';
        $company = $this->targetCompany ?: '[Nama Perusahaan]';
        $position = $this->targetPosition ?: '[Posisi]';
        $skills = $this->keySkills ?: 'manajemen waktu, komunikasi efektif, serta pemecahan masalah';
        $exp = $this->experienceYears;

        if ($this->workTone === 'antusias') {
            $this->generatedLetter = "Kepada Yth. HRD / Tim Rekrutmen\n{$company}\nDi Tempat\n\nDengan hormat,\n\nSaya menulis surat ini dengan antusiasme tinggi untuk mengajukan diri sebagai {$position} di {$company}. Berdasarkan rekam jejak dan keahlian yang saya miliki, saya sangat bersemangat untuk dapat berkontribusi aktif dalam mencapai visi dan target besar perusahaan Anda.\n\nDengan latar belakang pengalaman selama {$exp} dan penguasaan dalam {$skills}, saya terbiasa bekerja dengan dinamika cepat, berorientasi pada hasil, serta selalu berinisiatif memberikan solusi terbaik. Saya sangat mengagumi reputasi {$company} dan yakin bahwa kompetensi saya akan memberikan nilai tambah secara langsung bagi tim Anda.\n\nTerlampir CV dan portofolio saya sebagai bahan pertimbangan lebih lanjut. Saya sangat berharap mendapat kesempatan untuk berdiskusi lebih dalam mengenai bagaimana latar belakang saya dapat mendukung tujuan strategi {$company} melalui sesi wawancara.\n\nDemikian surat lamaran ini saya sampaikan. Atas perhatian dan kesempatan yang Bapak/Ibu berikan, saya ucapkan terima kasih.\n\nHormat saya,\n\n{$name}\nEmail: {$this->email}\nNo. HP: {$this->phone}";
        } elseif ($this->workTone === 'formal') {
            $this->generatedLetter = "Hal: Lamaran Pekerjaan - {$position}\n\nKepada Yth.\nBapak/Ibu Manajer Sumber Daya Manusia (HRD)\n{$company}\nDi Tempat\n\nDengan hormat,\n\nSehubungan dengan informasi lowongan pekerjaan yang dibuka oleh {$company}, melalui surat ini saya bermaksud untuk mengajukan diri guna mengisi posisi sebagai {$position}.\n\nSaya memiliki pengalaman kerja selama {$exp} dengan keahlian utama pada bidang {$skills}. Selama berkarir, saya senantiasa menjunjung tinggi profesionalisme, kedisiplinan, serta integritas dalam menyelesaikan setiap tanggung jawab pekerjaan sesuai dengan standar operasional yang ditetapkan.\n\nBesar harapan saya agar Bapak/Ibu berkenan memberikan kesempatan wawancara, sehingga saya dapat menjelaskan secara lebih rinci mengenai kualifikasi dan potensi yang saya miliki.\n\nDemikian surat lamaran pekerjaan ini saya buat dengan sebenarnya. Atas perhatian dan pertimbangan Bapak/Ibu, saya menyampaikan terima kasih.\n\nHormat saya,\n\n{$name}";
        } else {
            // Default Profesional Modern
            $this->generatedLetter = "Kepada Yth.\nTim Rekrutmen / HRD {$company}\nDi Tempat\n\nDengan hormat,\n\nMelalui surat ini, saya bermaksud untuk melamar posisi sebagai {$position} di {$company}. Saya memiliki ketertarikan yang besar terhadap perkembangan perusahaan Anda dan percaya bahwa kombinasi pengalaman serta keterampilan yang saya miliki dapat memberikan kontribusi positif.\n\nSaya berpengalaman selama {$exp} di bidang terkait dengan keahlian kuat dalam {$skills}. Selama ini, saya terbiasa mengelola proyek secara efektif, beradaptasi dengan teknologi baru, serta berkolaborasi dalam tim untuk mencapai target yang ditentukan.\n\nBersama surat ini, saya lampirkan CV terbaru sebagai bahan pertimbangan Bapak/Ibu. Saya sangat menyambut baik kesempatan untuk berdiskusi lebih lanjut dalam sesi wawancara.\n\nAtas perhatian dan kesempatan yang diberikan, saya ucapkan terima kasih.\n\nHormat saya,\n\n{$name}\nContact: {$this->email} | {$this->phone}";
        }

        $this->isGenerated = true;
    }

    public function resetForm()
    {
        $this->fullName = '';
        $this->email = '';
        $this->phone = '';
        $this->targetCompany = '';
        $this->targetPosition = '';
        $this->keySkills = '';
        $this->generatedLetter = '';
        $this->isGenerated = false;
    }

    public function render()
    {
        return view('livewire.cover-letter.cover-letter-generator')->layout('components.layouts.app');
    }
}
