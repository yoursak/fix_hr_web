<?php

namespace App\Models\admin\setupsettings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterEndGameModel extends Model
{
    use HasFactory;
    protected $table = "master_endgame_method";
    protected $primary_key = "id";
    // public function editholidaypolicy()
    // {
    //     return $this->belongsToMany(Editholidaypolicy::class, 'pivot_table_name', 'master_endgame_method_id', 'editholidaypolicy_id');
    // }
}