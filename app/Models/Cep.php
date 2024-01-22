<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Cep extends Model
{
    protected $table = 'cep';

    protected $fillable = [
        'cep',
        'logradouro',
        'bairro',
        'cidade',
        'uf',
        'complemento',
    ];

    protected $hidden = [
        'id',
        'ibge',
        'gia',
        'ddd',
        'siafi',
        'updated_at',
        'created_at'
    ];

    public $rules = [
        'cep' => 'required|min:8|max:10',
        'logradouro' => 'required|min:3|max:255',
        'complemento' => 'nullable|min:3|max:255',
        'bairro' => 'required|min:3|max:255',
        'cidade' => 'required|min:3|max:255',
        'uf' => 'required|size:2',
        'ibge' => 'nullable|min:3|max:255',
        'gia' => 'nullable|min:3|max:10',
        'ddd' => 'nullable|size:2',
        'siafi' => 'nullable|min:3|max:10',
    ];

    public function validate($isUpdate = false)
    {
        
        if($isUpdate){
            $this->rules['cep'] = 'required|size:8';
        }

        $validator = Validator::make($this->toArray(), $this->rules);
        if ($validator->passes()) return true;

        $this->errors = $validator->messages();
        return false;
    }

}


