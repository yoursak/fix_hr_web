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
class BusinessDetailsList extends Model
{
	protected $table = 'business_details_list';

	protected $casts = [
		'business_categories' => 'int',
		'business_type' => 'int'
	];

	protected $fillable = [
		'business_id',
		'business_logo',
		'business_categories',
		'client_name',
		'business_email',
		'business_name',
		'business_type',
		'mobile_no',
		'business_address',
		'gstnumber'
	];

	public function business_categories_list()
	{
		return $this->belongsTo(BusinessCategoriesList::class, 'business_categories');
	}

	public function business_type_list()
	{
		return $this->belongsTo(BusinessTypeList::class, 'business_type');
	}
}
