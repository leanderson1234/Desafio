@extends('admin.template.app')

@section('content')
    {{-- <h1> Adicionar novo Cliente</h1> --}}
 <div>
     {{$client}}
 </div>
    {{-- @includeIf('admin.includes.form', ['client' => $client]) --}}
    {{-- @include('admin.includes.form') --}}
    
@endsection

