<?php


namespace App\Models\admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BusinessDetailsList
 * 
 * @property int $id
 * @property string $business_id
 * @property string $business_logo
 * @property int $business_categories
 * @property string $client_name
 * @property string $business_email
 * @property string $business_name
 * @property int $business_type
 * @property string $mobile_no
 * @property string $business_address
 * @property string $gstnumber
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property BusinessCategoriesList $business_categories_list
 * @property BusinessTypeList $business_type_list
 *
 * @package App\Models
 */
class CameraPermissionModel extends Model
{
	protected $table = 'camera_permission';
    protected $primarykey='id';
}
