@extends('admin.template.app')

@section('content')
    <h1> {{$title}} Cliente </h1>
    @include('admin.includes.alert')
    
    @if ($title === 'Cadastrar')
        <form action="{{route('client.store')}}" method="post" name="formClient">
    @else
   
        <form action="{{route('client.update',$client['client_id']) ?? ''}}" name="formClient" method="post">
            @method('PUT')
            
    @endif
    
        @csrf
        
        <div class="form-group">
            <label for="">Empresa</label>
        <input type="text" class="form-control" id="empresa" name="empresa" value="{{$client['empresa'] ?? old('empresa')}}">
        </div>
        <div class="form-group">
            <label for="">CNPJ</label>
            <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{$client['cnpj'] ?? old('cnpj')}}">
        </div>
        <div class="form-group">
            <label for="">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" value="{{$client['telefone'] ?? old('telefone')}}">
        </div>
        <div class="form-group">
            <label for="">Responsável</label>
            <input type="text" class="form-control" id="responsavel" name="responsavel" value="{{$client['responsavel'] ?? old('responsavel')}}">
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$client['email'] ?? old('email')}}">
        </div>    
	
        <div class="form-group endereco_container" id="origem">
            <label id="endereco">Endereço</label>
            <div class="form-group">
                <a class="btn btn-secondary"   id="duplicarCampos"> + </a>
                
            </div>
            
            <div class="form-row "> 
                <div class="form-group col-1" > 
                    <label for=""> Principal</label>
                    <input type="radio" class="form-control" id="isPrimary" name="isPrimary" {{$client['isPrimary'] ?? ''}} >
                </div>
                <div class="form-group col-2"> 
                    <label for="">Cep</label>
                    <input type="text" class="form-control" id="cep" name="cep" value="{{$client['cep'] ?? old('cep')}}">
                </div>
                <div class="form-group col-4"> 
                    <label for="">Logradouro</label>
                    <input type="text" class="form-control" id="logradouro" name="logradouro" value="{{$client['logradouro'] ?? old('logradouro')}}" disabled>
                </div>
                <div class="form-group col-3"> 
                    <label for="">Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" value="{{$client['bairro'] ?? old('bairro')}}" disabled >
                </div>
                <div class="form-group col-4"> 
                    <label for="">Complemento</label>
                    <input type="text" class="form-control" id="complemento" name="complemento" value="{{$client['complemento'] ?? old('complemento')}}">
                </div>
                <div class="form-group col-2"> 
                    <label for="">Número</label>
                    <input type="text" class="form-control" id="numero" name="numero" value="{{$client['numero'] ?? old('numero')}}">
                </div>
                <div class="form-group col-2"> 
                    <label for="">Cidade</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" value="{{$client['cidade'] ?? old('cidade')}}" disabled>
                </div>
                <div class="form-group col-2"> 
                    <label for="">Estado</label>
                    <input type="text" class="form-control" id="estado" name="estado" value="{{$client['estado'] ?? old('estado')}}" disabled>
                </div>
            </div>
        </div>

       <div class="destino ">
           
       </div>
        
        <button type="submit" class="btn btn-primary submitDatas">{{$title}}</button>
    </form>
@endsection
@push('script')
<script> 

    $(document).ready(function () {
            $('#cep').blur(function(event){
     
            cep = $(this).val()
        $.ajax(
            {
                url: `https://viacep.com.br/ws/${cep}/json/`,
                type: "GET",
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    $("#bairro").val(response.bairro).prop('disabled', false).prop('readonly', true)
                    $("#logradouro").val(response.logradouro).prop('disabled', false).prop('readonly', true)
                    $("#cidade").val(response.localidade).prop('disabled', false).prop('readonly', true)
                    $("#estado").val(response.uf).prop('disabled', false).prop('readonly', true)
                    
                }
            }
        )
     
        })
        
    })
</script>
<script>
    var cont = 1
$( "#duplicarCampos" ).click(function() {
    cont++
    $( ".destino" )
    .append(     '<div class="form-row"id="campos'+cont+'" >'+ 
                
                    '<div class="form-group" >'+
                        '<a class="btn btn-secondary apagar"   id="'+cont+'"> - </a>'+
                    '</div>'+
                    '<div class="form-group " >'+
                            '<label for=""> Principal</label>'+
                            '<input type="radio" class="form-control" id="isPrimary" name="isPrimary" {{$client["isPrimary"] ?? ''}}>'+
                    '</div>'+
                    '<div class="form-group col-2"> '+
                        '<label for="">Cep</label>'+
                        '<input type="number" class="form-control" id="cep" name="cep" value="{{$client["cep"] ?? old("cep")}}"></div>'+
                    '</div>'+
                '</div>'
                 );
        
       
});

$("form").on( "click", ".apagar", function() {

        button_id = $( this ).attr( "id" );
        $('#campos'+button_id+'').remove();
});

$( ".submitDatas" ).click(function(event) {
  dados = $('form[name="formClient"]').serialize()
  $.post( "{{route('client.create')}}",dados)
})

        
</script>

@endpush
