<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProfileInformation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public object $profile, public string $userId = '', public string $username = '', public string $postCount = '', public string $favoriteCount = '', public int $totalFollowing = 0, public int $totalFollower = 0, public bool $following = false)
    {
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile-information');
    }
}
