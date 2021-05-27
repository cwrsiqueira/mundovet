@extends('adminlte::page')

@section('title', 'Calendário')

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
            <h1>Calendário</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/agenda')}}">Agenda</a></li>
                <li class="breadcrumb-item active">Calendário</li>
            </ol>
        </div>
    </div>
</div>
</section>

{{-- PAGE CONTENT --}}

<div class="card card-outline card-primary p-2">

    <div class="card-header">
      Clique nos dias disponíveis para marcar a consulta
    </div>

    <div class="card-body table-responsive p-2">
        <form method="POST" onchange="this.submit();">
    
            <div class="calendar">
              <div class="row table-calendar">
                <div class="col-sm-11">
                  <form method="POST" onchange="this.submit();">
  
                    <div class="row">

                      <div class="col-sm">

                          <div class="input-group mb-3">

                              <div class="input-group-prepend">
                                  <a href="{{asset('calendario/?mes='. $mes_anterior .'&ano='. $a )}}" class="input-group-text"><i class="fas  fa-arrow-left"></i></a>
                              </div>

                                  <input style="text-align: center; font-size: 26px; font-weight: bold;" type="text" class="form-control" placeholder="Email" type="text" name="mes" value="<?php echo $m_nome; ?>">

                              
                              <div class="input-group-prepend">
                                  <a href="{{asset('calendario/?mes='. $mes_posterior .'&ano='. $a )}}" class="input-group-text"><i class="fas  fa-arrow-right"></i></a>
                              </div>
                          </div>
                          
                      </div>

                      <div class="col-sm-2">
                          <button class="btn btn-secondary form-control mb-3">
                              <a 
                              style="color: #FFF;" 
                              href="{{asset('calendario/?ano=' .date('Y'). '&mes=' .date('m'). '&dia=' .date('d') )}}">
                                HOJE
                              </a>
                          </button>
                      </div>
  
                      <div class="col-sm">

                          <div class="input-group mb-3">

                              <div class="input-group-prepend">
                                  <a href="{{asset('calendario/?mes='.$m.'&ano='.($a-1))}}" class="input-group-text"><i class="fas  fa-arrow-left"></i></a>
                              </div>

                                  <input style="text-align: center; font-size: 26px; font-weight: bold;" type="text" class="form-control" placeholder="Email" type="text" name="ano" value="<?php echo ($a < 10)?'0'.$a:$a; ?>">

                              
                              <div class="input-group-prepend">
                                  <a href="{{asset('calendario/?mes='.$m.'&ano='.($a+1))}}" class="input-group-text"><i class="fas  fa-arrow-right"></i></a>
                              </div>
                          </div>

                      </div>
  
                    </div>
  
                    <div class="row">
  
                      <div class="col-sm">
  
                        <!-- DIAS -->
                        <table class="table table-hover table-calendar">
  
                          <thead>
                            <tr>
                              <th>Dom</th>
                              <th>Seg</th>
                              <th>Ter</th>
                              <th>Qua</th>
                              <th>Qui</th>
                              <th>Sex</th>
                              <th>Sáb</th>
                            </tr>
                          </thead>
  
                          <tbody>
                            <?php for( $linha = 0; $linha < 6; $linha++ ): ?>
                              <tr>
                                <?php for( $coluna = 0; $coluna < 7; $coluna++ ): ?>
                                <td 
                                  <?php
                                  
                                    if( ($diacorrente + 1 == ( date('d', $data_atual)) && date('m', $data_atual) == $m && date('Y', $data_atual) == $a) )
                                    { 
                                      echo " id = 'dia_atual' ";
                                    }
                                    else
                                    {
                                      if(($diacorrente + 1) <= $numero_dias )
                                      {
                                            if( $coluna < $diasemana && $linha == 0)
                                        {
                                            echo " id = 'dia_branco' ";
                                        }
                                        else
                                        {
                                            echo " id = 'dia_comum' ";
                                        }
                                      }
                                      else
                                      {
                                          echo 'style="display:none;"';
                                      }
                                    }
                                  ?>>
                                  <?php
  
                                    /* TRECHO IMPORTANTE: A PARTIR DESTE TRECHO É MOSTRADO UM DIA DO CALENDÁRIO (MUITA ATENÇÃO NA HORA DA MANUTENÇÃO) */
                  
                                    if( $diacorrente + 1 <= $numero_dias )
                                    {
                                      if( $coluna < $diasemana && $linha == 0)
                                      {
                                        echo " ";
                                      }
                                      else
                                      {
                                        $datacorrente = date('Y-m-d', strtotime($a.'-'.$m.'-'.($diacorrente+1)));
                                        if ( $datacorrente >= date('Y-m-d') ) 
                                        {
                                          foreach ($dt_disp as $dtd) 
                                          {
                                            if( ($dtd['day'] == strtolower(date('D', strtotime($datacorrente)))) && ($dtd['ini_atend'] > 0) )
                                            {
                                              $exclude_date = [];
                                              if (!empty($dt_except)) 
                                              {
                                                foreach ($dt_except as $dte) 
                                                {
                                                  if ($datacorrente >= $dte['ini_date'] && $datacorrente <= $dte['fin_date'] ) 
                                                  {
                                                    $exclude_date[] = $datacorrente;
                                                  }
                                                }
                                              }
                                              if(!in_array($datacorrente, $exclude_date))
                                              {
                                                echo '<a href="agenda/create/?ano='.$a.'&mes='.$m.'&dia='.($diacorrente+1).'"';
                                                echo " style='color:green;' ";
                                                echo ">";
                                              }
                                            }
                                          }
                                        }
                                        echo ++$diacorrente;
                                        echo "</a>";
                                      }
                                    }
                                    else
                                    {
                                      break;
                                    }
                                  
                                    /* FIM DO TRECHO MUITO IMPORTANTE */
  
                                    ?>
                                </td>
                                <?php endfor; ?>
                              </tr>
                            <?php endfor; ?>
                          </tbody>
                          
                        </table>
  
                      </div>
  
                    </div>
                  </form>
                </div>
            </div>
          </div>

        </form>
    </div>
    <!-- /.card-body -->

</div>
<!-- /.card -->

<div class="container" style="overflow: auto;">
    <div class="row table-calendar">
      <div class="col-sm-11">
        <div class="row">
          <br>
        </div>
        
      </div>
    </div>
</div>

{{-- END PAGE CONTENT --}}

@endsection

@section('footer')
    <footer>
        <div class="float-right d-none d-sm-inline">
        v3.0.3
        </div>
        <strong>Copyright © 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        | Powered & system developed by <strong>Copyright © 2020-{{date('Y')}} <a href="https://cwrsdevelopment.com/vetsystem">VetSystem</a>.</strong> All rights reserved.
    </footer>
@endsection

@section('css')
    <style>
        .table-calendar {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            justify-content: center;
        }
        .table-calendar td {
            border: 1px solid #ccc;
        }
        #dia_comum {
          color: #ccc;
        }
        #dia_atual {
          color: #555;
          background-color: #aaa;
        }
    </style>
@stop

@section('js')

@stop
