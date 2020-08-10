@extends('admin.template.app')

@section('content')

<div class="card text-white bg-secondary mb-3 text-center d-flex" >
<div class="card-header h1" >{{$data[0]->empresa}}</div>
    <div class="card-body">
      <h2 class="card-title ">Client:</h2>
        <p class="card-text h5">
            <span class="font-weight-bold">CNPJ:</span> {{$data[0]->cnpj}} 
        </p>
        <p class="card-text h5">
            <span class="font-weight-bold">Telefone:</span> {{$data[0]->telefone}}
        </p>
        <p class="card-text h5">
            <span class="font-weight-bold">responsavel:</span> {{$data[0]->responsavel}}
        </p>
        <p class="card-text h5">
            <span class="font-weight-bold">email:</span> {{$data[0]->telefone}}
        </p>
    </div>
  </div>
    @foreach ($data as $item)
    <div class="card text-white bg-secondary mb-3 text-center d-flex" >
        <div class="card-header h1" >Endereços</div>
            <div class="card-body">
              <h2 class="card-title ">Cep: {{$item->cep}} </h2>
              <p class="card-text h5">
                <span class="font-weight-bold">logradouro:</span> {{$item->logradouro}} 
                </p>
                <p class="card-text h5">
                    <span class="font-weight-bold">bairro:</span> {{$item->bairro}} 
                </p>
                <p class="card-text h5">
                    <span class="font-weight-bold">complemento:</span> {{$item->complemento}}
                </p>
                <p class="card-text h5">
                    <span class="font-weight-bold">numero:</span> {{$item->numero}}
                </p>
                <p class="card-text h5">
                    <span class="font-weight-bold">cidade:</span> {{$item->cidade}}
                </p>
                <p class="card-text h5">
                    <span class="font-weight-bold">estado:</span> {{$item->estado}}
                </p>
            </div>
          </div>
    @endforeach
  
@endsection