<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 * 
 * @property int $id
 * @property string $business_id
 * @property string $packages
 *
 * @package App\Models
 */
class SubscriptionModel extends Model
{
	protected $table = 'subscription';
	protected $primary_id = 'id';
	protected $business_id = 'business_id';
	protected $payment_merchant_id = 'payment_merchant_id';
	protected $payment_merchant_transaction = 'payment_merchant_transaction';
	protected $payment_transaction_id = 'payment_transaction_id';
	protected $payment_amount = 'payment_amount';
	protected $payment_date = 'payment_date';
	protected $active_status = 'active_status';
}
