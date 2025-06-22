<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TinymceEditor extends Component
{
    public $name;
    public $id;
    public $value;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $id = null, $value = '')
    {
        $this->name = $name;
        $this->id = $id ?? $name; // Jika ID tidak diberikan, gunakan nama
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.tinymce-editor');
    }
}