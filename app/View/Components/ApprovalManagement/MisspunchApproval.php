<?php

namespace App\View\Components\ApprovalManagement;

use Illuminate\View\Component;

class MisspunchApproval extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.approval-management.misspunch-approval');
    }
}
