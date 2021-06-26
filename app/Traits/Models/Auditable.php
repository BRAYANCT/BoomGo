<?php

namespace App\Traits\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;


trait Auditable 
{
    public static function boot()
    {
      parent::boot();
      
      static::creating(function($model){	

        // \Event::listen('auditable.created', $model);

        //usuario por defecto para el faker Generator
        $userId = 1;
   			if(Auth::check()){
   				 $userId = Auth::user()-> id;
   			}
        
        $model-> created_by = $userId;
        $model-> updated_by = $userId;

        // Log::debug('despues del evento');
      });

      static::updating(function($model){
        // \Event::listen('auditable.updated', $model);

        //usuario por defecto para el faker Generator
        $userId = 1;
   			if(Auth::check()){
   				$userId = Auth::user()-> id;
   			}

        $model-> updated_by = $userId;

         // Log::debug('UPDATEING CLASS AUDITABLE');
      });

      static::deleting(function($model){

        if(Schema::hasColumn($model->getTable(), 'deleted_by')){
          //usuario por defecto para el faker Generator
          $userId = 1;
          if(Auth::check()){
            $userId = Auth::user()-> id;
          }

          $model-> deleted_by = $userId;
          $model->save();

        }

      });
   }
}