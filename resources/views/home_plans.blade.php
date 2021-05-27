@extends('layouts.app')

@section('content')

<style>
    .row {
        display: flex;
        padding: 10px;
        margin: 10px;
    }

    .col-sm {
        padding: 10px;
        margin: 10px;
        max-width: 200px;
    }

    .btn {
        text-decoration: none;
        color:#fff;
        background-color:#424242;
        padding:5px 20px;;
        border-radius: 5px;
    }

    .col-sm > p:first-child {
        border-bottom: 1px solid #EEE;
        font-weight: bold;
    }

    .col-sm > p:nth-child(2) {
        text-decoration: line-through;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: rgba(0, 0, 0, 0)">
                <div class="card-header" style="background-color: #FFF">Nossos Planos</div>

                <div class="card-body" style="background-color: rgba(0, 0, 0, 0.7);">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm" style="background-color:#FFF; border-radius:10px; text-align:center; margin:10px; padding:5px;">
                                <p style="font-weight: bold;">Plano de 30 dias</p>
                                <p style="text-decoration: line-through;">De R$ 138,00</p>
                                <p style="text-decoration: line-through;">Por R$ 131,10</p>
                                <p>5% de desconto</p>
                                <p>Renovação Grátis<br>no período de avaliação</p>
                            </div>
                            <div class="col-sm" style="background-color:#FFF; border-radius:10px; text-align:center; margin:10px; padding:5px;">
                                <p style="font-weight: bold;">Plano de 6 meses</p>
                                <p style="text-decoration: line-through;">De R$ 828,00</p>
                                <p style="text-decoration: line-through;">Por R$ 745,20</p>
                                <p>10% de desconto</p>
                                <p>Indisponível<br>no período de avaliação</p>
                            </div>
                            <div class="col-sm" style="background-color:#FFF; border-radius:10px; text-align:center; margin:10px; padding:5px;">
                                <p style="font-weight: bold;">Plano de 1 ano</p>
                                <p style="text-decoration: line-through;">De R$ 1.656,00</p>
                                <p style="text-decoration: line-through;">Por R$ 1.324,80</p>
                                <p>20% de desconto</p>
                                <p>Indisponível<br>no período de avaliação</p>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <a href="{{route('register')}}" class="btn btn-primary m-3">Entrar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
