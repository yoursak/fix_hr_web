<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BusinessDetailsList
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $business_logo
 * @property int|null $business_categories
 * @property string|null $client_name
 * @property string|null $business_email
 * @property string|null $business_name
 * @property int|null $business_type
 * @property string|null $mobile_no
 * @property string|null $city
 * @property string|null $state
 * @property string|null $country
 * @property string|null $business_address
 * @property string|null $pin_code
 * @property string|null $gstnumber
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class BusinessDetailsList extends Model
{
	protected $table = 'business_details_list';
	protected $primary_key='id';
	// protected $casts = [
	// 	'business_categories' => 'int',
	// 	'business_type' => 'int'
	// ];

	// protected $fillable = [
	// 	'business_id',
	// 	'business_logo',
	// 	'business_categories',
	// 	'client_name',
	// 	'business_email',
	// 	'business_name',
	// 	'business_type',
	// 	'mobile_no',
	// 	'city',
	// 	'state',
	// 	'country',
	// 	'business_address',
	// 	'pin_code',
	// 	'gstnumber'
	// ];
}
