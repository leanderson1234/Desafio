<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateClientRequest;
use App\Models\Adress;
use App\Models\Client as Clients;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\Routing\Route;

// use PhpParser\Node\Expr\Cast\Object_;
// use Prophecy\Argument\Token\ObjectStateToken;
// use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{  
    private $client;
    private $adress;
    public function __construct(Clients $client,Adress $adress)
    {
        $this->client = $client;
        $this->adress = $adress;
        // $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $id = [];
       foreach ($this->client->get() as  $d) {
        $id = $d->getOriginal('id');
       }
       
        return view('admin.pages.client.index',['id' => $id]);
    }
    public function data(Request $request){

        $json_array = [];
        $datas = [];
        
        foreach ($this->client->get() as  $d) {
            $data = $this->adress->getAll($d->getOriginal('id'));
            
        }
        foreach ($data as  $d) {
            $datas[] =$d->getOriginal();
        }

        $json_array[] = [
                "draw"              => (int)$data->currentPage(),
                "recordsTotal"      => (int)$data->total(),
                "recordsFiltered"   => 0,
                 "data"             => $datas
        ];
            echo json_encode($json_array[0]);   
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.pages.client.create',['title' => 'Cadastrar']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateClientRequest $request)
    {

        $data = $request->except('_token','cep');
         
        $clientCreate = $this->client->create($data);
        $dataAdress = $request->only('cep','logradouro','bairro','complemento','numero','cidade','estado','isPrimary');
        $dataAdress['client_id'] = $clientCreate->id;

      
            if($dataAdress['isPrimary'] == 'on'){
                $dataAdress['isPrimary'] = 1;
            }else{
                $dataAdress['isPrimary'] = 0;
            }
            // dd($dataAdress['isPrimary']);
    
        $url = [];
        $resposta = [];
        $dataCep =[];
        
            // dd($request->only('cep')['cep']);
            foreach($request->only('cep') as $cep){
                array_push($url,"https://viacep.com.br/ws/$cep/json/") ;
            }

        
        foreach($url as $u){
            $ch = curl_init($u);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            array_push($resposta , curl_exec($ch));
            
        }
        
        foreach ($resposta as $key=> $val) {
            array_push($dataCep , json_decode($val));
            // foreach ($dataCep as  $value) {
               
               $endereco[] = array("cep"=>$dataCep[$key]->cep,
                "logradouro"=>$dataCep[$key]->logradouro,
                "bairro"=>$dataCep[$key]->bairro,
                "cidade"=>$dataCep[$key]->localidade,
                "estado"=>$dataCep[$key]->uf,
            );
        // }
    }
    $dataAdress['endereco'] =  $endereco;  
    
    // $enderecos[] =$dataCep;
    // $dataAdress['enderecos'] = ["cep"=> $enderecos[0]];
    //   $i = 0;
    
    
    // dd($dataAdress);
    
        $this->adress->create($dataAdress);
        return redirect()->route('client.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataEdit = $this->adress->edit($id);
        return view('admin.pages.client.card',['data'=>$dataEdit]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataEdit = $this->adress->edit($id);
       
        if(!$dataEdit) return redirect()->back();
        $client = [];
        foreach ($dataEdit as $d) {
            $client = $d->getOriginal();
            if($d->getOriginal('isPrimary') != 0 ){ 
                $client['isPrimary'] = 'checked';

            }
        }
       
        return view('admin.includes.form',['client' => $client,'title' => 'Editar']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateClientRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateClientRequest $request, $id)
    {
       
        $dataEdit = $this->adress->edit($id);
        if(!$dataEdit) return redirect()->back();
        $client = $this->client->find($dataEdit[0]->getOriginal('client_id'));
        $adress = $this->adress->find($dataEdit[0]->getOriginal('id'));
        
        $data = $request->except('_token','cep','logradouro','bairro','complemento','numero','cidade','estado'); 
        
        $client->update($data);

        $dataAdress = $request->only(
            // 'cep','logradouro','bairro','complemento','numero','cidade','estado',
                                    'isPrimary');
        $dataAdress['client_id'] = $dataEdit[0]->getOriginal('client_id');
       
    //    $dataAdress['cep'] = $dataAdress['cep'][0];
    //    $dataAdress['logradouro'] = $dataAdress['logradouro'][0];
    //    $dataAdress['bairro'] = $dataAdress['bairro'][0];
    //    $dataAdress['complemento'] = $dataAdress['complemento'][0];
    //    $dataAdress['numero'] = $dataAdress['numero'][0];
    //    $dataAdress['cidade'] = $dataAdress['cidade'][0];
    //    $dataAdress['estado'] = $dataAdress['estado'][0];
    // dd($dataAdress['logradouro']);
    
    // dd($request->only('isPrimary'));
    foreach ($dataAdress['isPrimary'] as $key => $value) {
       
            if($value == 'on'){
                $dataAdress['isPrimary'] = 1;
            }else{
                $dataAdress['isPrimary'] = 0;
            }
            // dd($dataAdress['isPrimary']);
    }
        $url = [];
        $resposta = [];
        $dataCep =[];
        foreach($request->only('cep')['cep'] as $cep){
            array_push($url,"https://viacep.com.br/ws/$cep/json/") ;
        }
        foreach($url as $u){
            $ch = curl_init($u);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            array_push($resposta , curl_exec($ch));
            
        }
        
        foreach ($resposta as $key=> $val) {
            array_push($dataCep , json_decode($val));
            // foreach ($dataCep as  $value) {
               
               $endereco[] = array("cep"=>$dataCep[$key]->cep,
                "logradouro"=>$dataCep[$key]->logradouro,
                "bairro"=>$dataCep[$key]->bairro,
                "cidade"=>$dataCep[$key]->localidade,
                "estado"=>$dataCep[$key]->uf,
            );
        // }
    }
    $dataAdress['endereco'] =  $endereco;  
    
    // $enderecos[] =$dataCep;
    // $dataAdress['enderecos'] = ["cep"=> $enderecos[0]];
    //   $i = 0;
    
    
    // dd($dataAdress);
    $adress->update($dataAdress);
    curl_close($ch);
    
    
    return redirect()->route('client.index');
}

/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataEdit = $this->adress->edit($id);
        if(!$dataEdit) return redirect()->route('client.index');

        $client = $this->client->find($dataEdit[0]->getOriginal('client_id'));
        $adress = $this->adress->find($dataEdit[0]->getOriginal('id'));
        
        $adress->delete();
        $client->delete();
        return redirect()->route('client.index');
    }
  
   
}
