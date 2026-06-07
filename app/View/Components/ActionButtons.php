<?php
namespace App\View\Components;

use Illuminate\View\Component;

class ActionButtons extends Component
{
    public $id;
    public $show;
    public $edit;
    public $delete;

    public function __construct($id, $show = null, $edit = null, $delete = false)
    {
        $this->id     = $id;
        $this->show   = $show;
        $this->edit   = $edit;
        $this->delete = $delete;
    }

    public function render()
    {
        return view('components.action-buttons');
    }
}
