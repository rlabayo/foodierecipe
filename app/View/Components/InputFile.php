<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputFile extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $id = 'attachment', public string $updateValue = "", public int $width=300, public int $height=300)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-file');
    }
}
