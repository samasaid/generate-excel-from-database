<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// this is used if there is authentucation to use to return the token
use Tymon\JWTAuth\Contracts\JWTSubject;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $dateFormat = 'mm-dd-yyyy';
    public $timestamps = false;
    /**
    * The attributes that are mass assignable.
    *
    * @var string[]
    */
   protected $fillable = [
       'id',
       'first_name',
       'last_name',
       'hiringDate',
   ];

   public function getHiringDateAttribute($value){
    return Carbon::parse($value)->format('mm-dd-yyyy');
   }






    // these are used if there is authentucation to use to return the token

     // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
