@extends('admin.template.app')

@section('content')
@push('style')
    <link   rel="stylesheet" 
            type="text/css" 
            href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">  
@endpush

<div class="container p-2">
    <a  type="button" 
        class="btn btn-primary"
        href="{{route('client.create')}}">
        Adicionar
    </a>
</div>

<table id="table_client" class="display" class="hover row-border" >
    
    <thead>
        <tr> 
            <th>Empresa</th>
            <th>CNPJ</th>
            <th>Telefone</th>
            <th>Responsável</th>
            <th>Email</th>
            <th>Endereço</th>         
            <th>Ações</th> 
            
        </tr>
    </thead>
    <tbody>
        
        
    </tbody>
    <tfoot>
        
    </tfoot>
</table>

@push('script')
    <script 
        type="text/javascript" 
        charset="utf8" 
        src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js">
    </script>

    <script type="text/javascript">
    $(document).ready(function() {
        
       
        $('#table_client').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('client.data')}}",
                type: 'GET',
                },
            columns:[
                { data: 'empresa'       },
                { data: 'cnpj'          },
                { data: 'telefone'      },
                { data: 'responsavel'   },
                { data: 'email'         },
                { data: 'cep'           },
                { data: function (data,type) {
                    actions = [`<div class='d-inline-flex '>`
                                +`<a class='btn btn-primary  mr-2' href="{{route('client.edit',$id)}}">Editar</a>`
                                +`<a class='btn btn-primary  mr-2' href="{{route('client.show',$id)}}">Detalhes</a>`
                                +`<a class='btn btn-danger   mr-2' href="{{route('client.destroy',$id)}}">Deletar</a> </div>`]
                            
                     return actions
                     }
                },
            ],
            responsive: true,
           	
        });
    });
    
   </script>
   
@endpush

   
@endsection