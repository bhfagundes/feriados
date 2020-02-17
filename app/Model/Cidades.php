<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cidades extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cidades';
   

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}