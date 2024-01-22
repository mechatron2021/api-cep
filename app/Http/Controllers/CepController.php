<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use App\Models\Cep;
use Exception;

class CepController extends Controller
{
    private $searchFields = array();
    private $fields = array();
   
    public function show(string $cep)
    {
        $data = Cep::where('cep', $cep)->first();
        if (!$data) {
            $data = $this->search($cep);
            $data = $data->getData(true);
            if (array_key_exists('cep', $data)) {
                $cep = new Cep();
                $cep->cep = preg_replace('/[^A-Za-z0-9 ]/', '', $data['cep']);
                $cep->logradouro = $data['logradouro'];
                $cep->complemento = $data['complemento'];
                $cep->bairro = $data['bairro'];
                $cep->cidade = $data['localidade'];
                $cep->uf = $data['uf'];
                $cep->ibge = $data['ibge'];
                $cep->gia = $data['gia'];
                $cep->ddd = $data['ddd'];
                $cep->siafi = $data['siafi'];
                try {
                    DB::beginTransaction();
                    $cep->save();
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    return json_decode($e->getMessage());
                }
                $cep->save();
                echo  response()->json(['msg' => 'CEP INSERIDO COM SUCESSO'], Response::HTTP_OK);
            }
        }

        return $data;
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $cep = Cep::select('id')->where('cep', preg_replace('/[^A-Za-z0-9 ]/', '', $data['cep']))->first();

        if (!$cep) {
            return response()->json(['msg' => 'CEP NÃO ENCONTRADO'], Response::HTTP_NOT_FOUND);
        }

        $cep->cep = preg_replace('/[^A-Za-z0-9 ]/', '', $data['cep']);
        $cep->logradouro = $data['logradouro'];
        $cep->complemento = $data['complemento'];
        $cep->bairro = $data['bairro'];
        $cep->cidade = $data['localidade'];
        $cep->uf = $data['uf'];
        $cep->ibge = $data['ibge'];
        $cep->gia = $data['gia'];
        $cep->ddd = $data['ddd'];
        $cep->siafi = $data['siafi'];

        if (!$cep->validate()) {
            $error =  new Exception($cep->errors);
            $error = $error->getMessage();
            return response()->json(['msg' => $error], Response::HTTP_BAD_REQUEST);
        }

        $cep->save();

        return response()->json(['msg' => 'CEP ATUALIZADO COM SUCESSO'], Response::HTTP_OK);

    }

    public function destroy(string $id)
    {
        $cep = Cep::select('id')->where('cep', preg_replace('/[^A-Za-z0-9 ]/', '', $id))->first();

        if (!$cep) {
            return response()->json(['erro' => 'CEP NÃO ENCONTRADO.'], Response::HTTP_NOT_FOUND);
        }

        $cep->delete();

        return response()->json(['mensagem' => 'CEP DELETADO COM SUCESSO'], Response::HTTP_OK);
    
    }

    public function search($cep)
    {
        $url = "https://viacep.com.br/ws/{$cep}/json/";

        $client = new Client(['verify' => false]);

        $response = $client->request('GET', $url);

        $data = json_decode($response->getBody(), true);
      
        return response()->json($data);
        
    }

    public function fuzzySearch(Request $request){

        $this->fields =  $request->all();
   
        $cep = Cep::where(function ($query) {
           foreach ($this->fields as $field => $value) {
                $query->where($field, 'LIKE', '%' . $value . '%');
           }
       })->get();

       return response()->json($cep, 200);
      
    }
}
