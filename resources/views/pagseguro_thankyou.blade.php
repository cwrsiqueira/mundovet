@extends('adminlte::page')

@section('title', 'Obrigado')

@section('content')

@if ($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    <h5>
        <i class="icon fas fa-ban"></i>
        Erro!!!
    </h5>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Obrigado!</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Obrigado</li>
            </ol>
        </div>
    </div>
</div>
</section>

{{-- PAGE CONTENT --}}

    <h3>Obrigado por utilizar nosso sistema!</h3>
    <p>Qualquer dúvida entre em contato como o nosso suporte (96) 99110-0041 no horário comercial, <br>
    ou deixe mensagem no whatsapp com mesmo número, e ainda, você pode enviar um e-mail para <br>
    contato@cwrsdevelopment.com</p>
    <a href="{{route('home')}}">Volte para página inicial</a>

{{-- END PAGE CONTENT --}}

@endsection

@section('footer')
    <footer>
        @include('layouts.footer')
    </footer>
@endsection

@section('css')

@stop

@section('js')

@stop
