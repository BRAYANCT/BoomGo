<?php

namespace App;

use App\Traits\Models\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use Auditable;

    protected $table = 'claims';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_type_id','district_id','names','surnames','identification_document','phone','email','address',
        'tutor_full_name','tutor_email','tutor_document_type_id','tutor_identification_document',
        'claim_type','related_claim','detail_claims','client_request','amount'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class,'document_type_id','id');
    }

    public function tutorDocumentType()
    {
        return $this->belongsTo(DocumentType::class,'tutor_document_type_id','id');
    }

    public function district()
    {
        return $this->belongsTo(District::class,'district_id','id');
    }

    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    public function getDisplayCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('d/m/Y H:i');
        }
    }

    public function getDisplayDateCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('d/m/Y');
        }
    }

    public function getDisplayHourCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('H:i');
        }
    }

    public function getCodeAttribute(){

        $id =  $this->attributes['id'];

        $code = "";

        for($i=0;$i< 4 - strlen($id) ;$i++){
            $code .= "0";
        }
        $code .= $id;

        return $code;
    }
}
