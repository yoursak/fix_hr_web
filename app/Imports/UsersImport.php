<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $rowCount = 0;

    public function model(array $row)
    {
        $this->rowCount++;

        // Skip the first two rows
        if ($this->rowCount <= 2) {
            return null;
        }

        $transporters = Product::where('prod_id', $row[0])->first();
        $db_value= DB::table('product_category')->where('cat_name',$row[2])->first();
        $db = $db_value ? $db_value->cat_id : null;
        if ($row[27] == 'Active') {
            $value = 1;
        } else if ($row[27] == 'Inactive') {
            $value = 0;
        } else {
            $value = 1;
        }
        if (isset($row[1], $row[2], $row[4], $row[5], $row[6], $row[10], $row[12], $row[13], $row[14], $row[15], $row[16], $row[17], $row[18], $row[19])) {
            if ($transporters==true) {
                $transporters->update([
                    'mf_id' => session()->get('manufacturerId'),
                    'prod_type' => $row[1],
                    'cat_id' => $db,
                    'prod_model_type' => $row[3],
                    'prod_name' => $row[4],
                    'prod_total_price' => $row[5],
                    'prod_nsv' => $row[6],
                    'prod_sale_commision_slot_a' => $row[7],
                    'prod_sale_commision_slot_b' => $row[8],
                    'prod_service_commision' => $row[9],
                    'prod_std_warranty' => $row[10],
                    'prod_exd_warranty' => $row[11],
                    'prod_attachments' => $row[12],
                    'prod_descr' => $row[13],
                    'prod_house_power' => $row[14],
                    'prod_fuel_used' => $row[15],
                    'prod_cylinders' => $row[16],
                    'prod_yom' => $row[17],
                    'prod_seating' => $row[18],
                    'prod_unladen_weight' => $row[19],
                    'prod_front_axle' => $row[20],
                    'prod_rear_axle' => $row[21],
                    'prod_other_axle' => $row[22],
                    'prod_tandem_axle' => $row[23],
                    'prod_gross_weight' => $row[24],
                    'prod_body_color' => $row[25],
                    'prod_body_type' => $row[26],
                    'prod_addedfrom' => session()->get('loginId'),
                    'prod_status ' => $value,
                ]);
            } else {
                $client = new Product([
                    'mf_id' => session()->get('manufacturerId'),
                    'prod_type' => $row[1],
                    'cat_id' => $db,
                    'prod_model_type' => $row[3],
                    'prod_name' => $row[4],
                    'prod_total_price' => $row[5],
                    'prod_nsv' => $row[6],
                    'prod_sale_commision_slot_a' => $row[7],
                    'prod_sale_commision_slot_b' => $row[8],
                    'prod_service_commision' => $row[9],
                    'prod_std_warranty' => $row[10],
                    'prod_exd_warranty' => $row[11],
                    'prod_attachments' => $row[12],
                    'prod_descr' => $row[13],
                    'prod_house_power' => $row[14],
                    'prod_fuel_used' => $row[15],
                    'prod_cylinders' => $row[16],
                    'prod_yom' => $row[17],
                    'prod_seating' => $row[18],
                    'prod_unladen_weight' => $row[19],
                    'prod_front_axle' => $row[20],
                    'prod_rear_axle' => $row[21],
                    'prod_other_axle' => $row[22],
                    'prod_tandem_axle' => $row[23],
                    'prod_gross_weight' => $row[24],
                    'prod_body_color' => $row[25],
                    'prod_body_type' => $row[26],
                    'prod_addedfrom' => session()->get('loginId'),
                    'prod_status ' => $value,
                ]);
                $client->save();
            }
        }else{
           return;
        }

    }
}
