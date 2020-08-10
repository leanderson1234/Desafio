@extends('admin.template.app')

@section('content')
    {{-- <h1> Adicionar novo Cliente</h1> --}}
   @include('admin.includes.form')
    
@endsection
{{-- @push('script')
<script> 

    $(document).ready(function () {
        // $('form[name=formClient]').submit(function(event){
            $('#cep').blur(function(event){
        // event.preventDefault()
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
@endpush --}}
