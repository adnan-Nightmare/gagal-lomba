<?php

namespace App\View\Components;

use Closure;
use App\Models\store;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class navbar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $store = store::where('user_id', Auth::user()->id)->first();
        
        return view('components.navbar', compact('store'));
    }
}
