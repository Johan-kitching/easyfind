<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class codes_and_descriptions extends Model
{
    protected $fillable =['mmcode','vehicle_type','make','model','variant','reg_year','publication_section','master_model','make_code','model_code','variant_code','axle_configuration','body_type','no_of_doors','drive','seats','use','wheelbase','manual_auto','no_gears','cooling','cubic_capacity','cyl_configuration','engine_cycle','fuel_tank_size','fuel_type','kilowatts','no_cylinders','turbo_or_super_charged','gcm','gvm','tare','origin','front_no_tyres','front_tyre_size','rear_no_tyres','rear_tyre_size','intro_date','disc_date','co_2','length','height','width','new_list_price'];
}
