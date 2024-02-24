<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListComment extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public object $comments, public int $totalComments = 0, public int $recipeCreator)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.list-comment');
    }
}
