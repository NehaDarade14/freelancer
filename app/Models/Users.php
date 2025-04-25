<?php

namespace Fickrr\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Users extends Model
{



     public static function getvendorData()
  {

    $value=DB::table('users')->where('user_type','=','vendor')->where('drop_status','=','no')->orderBy('id', 'desc')->get(); 
    return $value;
	
  }
    /**
     * Get the user types associated with the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function types()
    {
        return $this->hasMany(UserType::class);
    }

    /**
     * Check if the user has a given type.
     *
     * @param  string $type
     * @return boolean
     */
      public function hasType($type)
      {
          return $this->types->contains('type', $type);
      }

  
  
}
