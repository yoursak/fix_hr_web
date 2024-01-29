<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticSidebarMenu
 * 
 * @property int $menu_id
 * @property string|null $menu_name
 * @property string|null $menu_link
 * @property string|null $sub_list
 * @property int|null $sidebar_id
 * @property int|null $status
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * 
 * @property Collection|Permission[] $permissions
 *
 * @package App\Models
 */
class StaticCountryModel extends Model
{
    protected $table = 'static_countries';
    protected $primaryKey = 'id';
}
