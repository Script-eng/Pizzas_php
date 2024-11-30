<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Category;
use App\Models\MenuItem;

class Navbar extends Component
{
    public $categories;
    public $featuredItems;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Fetch menu items
        $this->featuredItems = MenuItem::where('is_available', true)->get();

        // Fetch categories with their children and items
        $this->categories = Category::orderBy('price')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Return the view and pass the categories and featured items
        return view('components.navbar', [
            'categories' => $this->categories,
            'featuredItems' => $this->featuredItems
        ]);
    }
}
