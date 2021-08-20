<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class enquiry_form extends Model
{
    public $table = "enquiry_form";
    protected $fillable = ['id','first_name','last_name','birthday','gender','email','phone','facilities1','facilities2','facilities3','facilities4','facilities5','facilities6','facilities7','facilities8','facilities9','facilities10','facilities11','facilities12','address','Status','createdat',];
}