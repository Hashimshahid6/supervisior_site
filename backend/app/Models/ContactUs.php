<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table="contact_us";
    protected $fillable=["name","email","message","created_at"];
    //
    public static function save_contact_form(){
        self::create([
	        'name' => request()->post('name'),
	        'email' => request()->post('email'),
	        'message' => request()->post('message'),
	        'created_at' => date('Y-m-d H:i:s'),
	    ]);
	    return array(
	        'status' => 200,
	        'message' => 'Record Saved Successfully'
        );
    } //
}
