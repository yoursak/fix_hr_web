<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidebarMenu extends Model
{
    use HasFactory;
    protected $table="menu_list_type";
    protected $primary_key= "id";
}
