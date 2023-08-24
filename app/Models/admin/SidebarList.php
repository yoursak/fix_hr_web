<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidebarList extends Model
{
    use HasFactory;
    protected $table ="sidebar_manage";
    protected $primary_key= "id";
}
