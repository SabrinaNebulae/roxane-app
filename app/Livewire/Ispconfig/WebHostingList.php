<?php

namespace App\Livewire\Ispconfig;

use App\Enums\IspconfigType;
use Illuminate\View\View;
use App\Models\Member;
use Livewire\Component;

class WebHostingList extends Component
{
    public Member $member;

    public function render(): View
    {
        $websites = $this->member
            ->ispconfigs()
            ->where('type', IspconfigType::WEB)
            ->get();

        return view('livewire.ispconfig.web-hosting-list', [
            'websites' => $websites,
        ]);
    }
}
