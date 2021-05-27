<style>
  .table {
    text-align: center;
    font-size: 18px;
  }
  #dia_atual {
    background-color: antiquewhite;
    font-weight: bold;
  }
  #dia_atual:hover {
    background-color: #CCC;
  }
  .dia_disp {
    background-color:#81F781;
    cursor: pointer;
  }
  .dia_disp:hover {
    font-weight: bold;
    background-color: darkgreen;
    color: #FFF;
  }
  .box-legenda {
    width: 20px;
    height: 20px;
    border-radius: 2px;
    background-color: #81F781;
  }
</style>

<div class="container">

  <div class="d-flex row p-2 m-2">

    <div class="col-md">
      <select class="form-control" name="selec_month" id="selec_month">
        <option @if($dados['m'] == '1') selected @endif value="1">Janeiro</option>
        <option @if($dados['m'] == '2') selected @endif value="2">Fevereiro</option>
        <option @if($dados['m'] == '3') selected @endif value="3">Março</option>
        <option @if($dados['m'] == '4') selected @endif value="4">Abril</option>
        <option @if($dados['m'] == '5') selected @endif value="5">Maio</option>
        <option @if($dados['m'] == '6') selected @endif value="6">Junho</option>
        <option @if($dados['m'] == '7') selected @endif value="7">Julho</option>
        <option @if($dados['m'] == '8') selected @endif value="8">Agosto</option>
        <option @if($dados['m'] == '9') selected @endif value="9">Setembro</option>
        <option @if($dados['m'] == '10') selected @endif value="10">Outubro</option>
        <option @if($dados['m'] == '11') selected @endif value="11">Novembro</option>
        <option @if($dados['m'] == '12') selected @endif value="12">Dezembro</option>
      </select>
    </div>
    
    <div class="col-md d-flex align-items-center" style="border: 1px solid #ccc;">

      <div class="col-sm d-flex justify-content-center" id="year_less">
        <i class="fas fa-angle-double-left"></i>
      </div>
      <div class="col-sm d-flex justify-content-center">
        {{$dados['a']}}
      </div>
      <div class="col-sm d-flex justify-content-center" id="year_plus">
        <i class="fas fa-angle-double-right"></i>
      </div>
      
    </div>
  </div>

  <div id="calendar"></div>
  <table class="table">
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
      @for ($linha = 0; $linha < 6; $linha++)
          <tr>

            @for ($coluna = 0; $coluna < 7; $coluna++)

              <td

              @if( ($dados['diacorrente'] + 1) <= $dados['numero_dias'] )
              
                @if( $coluna < $dados['diasemana'] && $linha == 0)
                  
                @else
                  

                  {{$datacorrente = date('Y-m-d', strtotime($dados['a'].'-'.$dados['m'].'-'.($dados['diacorrente']+1)))}}
                  @if ( $datacorrente > date('Y-m-d') ) 
                  
                    @foreach ($dados['dt_disp'] as $dtd) 
                    
                      @if( ($dtd['day'] == strtolower(date('D', strtotime($datacorrente)))) && ($dtd['ini_atend'] > 0) )
                        <?php $exclude_date = array(); ?>
                        @if (!empty($dados['dt_except'])) 
                        
                          @foreach ($dados['dt_except'] as $dte) 
                          
                            @if ($datacorrente >= $dte['ini_date'] && $datacorrente <= $dte['fin_date'] ) 
                              {{$exclude_date[] = $datacorrente}}
                            @endif
                          @endforeach

                        @endif

                        @if(!in_array($datacorrente, $exclude_date))
                          class='dia_disp'
                        @endif

                      @endif

                    @endforeach

                  @endif

                @endif
                
              @endif

                @if ( ($dados['diacorrente'] + 1 == ( date('d', $dados['data_atual'])) && date('m', $dados    ['data_atual']) == $dados['m'] && date('Y', $dados['data_atual']) == $dados['a']) )

                  id="dia_atual"

                  @else 

                    @if ( ($dados['diacorrente'] + 1) <= $dados['numero_dias'] )

                      @if ( $coluna < $dados['diasemana'] && $linha == 0 )
                          id="dia_branco"
                      @else
                          id="dia_comum"
                      @endif
                        
                      @else
                      
                      style="display: none;"

                    @endif

                @endif
              >@if ( ($dados['diacorrente']) <= $dados['numero_dias'] )@if ( $coluna < $dados['diasemana'] && $linha == 0 )@else{{++$dados['diacorrente']}}@endif</td> 
              @else 
              @endif
            @endfor
          </tr>
      @endfor
    </tbody>
  </table>
  <div class="d-flex justify-content-start m-2 p-2 align-items-center">
    <div class="box-legenda m-1"></div>
    <div class="texto-legenda">Dias Disponíveis</div>
  </div>
</div>


-----------------------------------------------------------------
<?php 

        @for ($linha = 0; $linha < 6; $linha++)
          for (let linha = 0; linha < 6; linha++) {
        
        html = '<tr>';

          for (let coluna = 0; coluna < 7; coluna++) {
            
            html += '<td';

            if ( (diacorrente + 1) <= numero_dias ) {
              
              if ( coluna < diasemana && linha == 0 ) {
                
              } else {

                let datacorrente = a+'-'+m+'-'+(diacorrente+1);
                if ( $datacorrente > hoje ) {

                  dt_disp.forEach(dtd => {
                    
                    @if( ($dtd['day'] == strtolower(date('D', strtotime($datacorrente)))) && ($dtd['ini_atend'] > 0) )

                    if ( dtd.day == dia_semana && dtd.ini_atend > 0 ) {
                      
                    }

                  });
                  
                }
              }
            }
            
          }

        
      }
            <tr>
  
              @for ($coluna = 0; $coluna < 7; $coluna++)

                <div id="calendar_in"></div>
                
                <td
  
                @if( ($dados['diacorrente'] + 1) <= $dados['numero_dias'] )
                
                  @if( $coluna < $dados['diasemana'] && $linha == 0)
                    
                  @else
                    
  
                    {{$datacorrente = date('Y-m-d', strtotime($dados['a'].'-'.$dados['m'].'-'.($dados['diacorrente']+1)))}}
                    @if ( $datacorrente > date('Y-m-d') ) 
                    
                      @foreach ($dados['dt_disp'] as $dtd) 
                      
                        @if( ($dtd['day'] == strtolower(date('D', strtotime($datacorrente)))) && ($dtd['ini_atend'] > 0) )
                          <?php $exclude_date = array(); ?>
                          @if (!empty($dados['dt_except'])) 
                          
                            @foreach ($dados['dt_except'] as $dte) 
                            
                              @if ($datacorrente >= $dte['ini_date'] && $datacorrente <= $dte['fin_date'] ) 
                                {{$exclude_date[] = $datacorrente}}
                              @endif
                            @endforeach
  
                          @endif
  
                          @if(!in_array($datacorrente, $exclude_date))
                            class='dia_disp'
                          @endif
  
                        @endif
  
                      @endforeach
  
                    @endif
  
                  @endif
                  
                @endif /// já fiz ate´aqui
  
                  @if ( ($dados['diacorrente'] + 1 == ( date('d', $dados['data_atual'])) && date('m', $dados    ['data_atual']) == $dados['m'] && date('Y', $dados['data_atual']) == $dados['a']) )
  
                    id="dia_atual"
  
                  @else 
  
                      @if ( ($dados['diacorrente'] + 1) <= $dados['numero_dias'] )
  
                        @if ( $coluna < $dados['diasemana'] && $linha == 0 )
                            id="dia_branco"
                        @else
                            id="dia_comum"
                        @endif
                          
                        @else
                        
                        style="display: none;"
  
                      @endif
  
                  @endif


                >
                
                @if ( ($dados['diacorrente']) <= $dados['numero_dias'] )
                  @if ( $coluna < $dados['diasemana'] && $linha == 0 )
                  
                  @else
                  
                  {{++$dados['diacorrente']}}
                  
                  @endif
              
                  </td> 

                @endif

              @endfor
            </tr>
        @endfor

        
  #dia_atual {
    background-color: antiquewhite;
    font-weight: bold;
  }
  #dia_atual:hover {
    background-color: #CCC;
  }
  .dia_disp {
    background-color:#81F781;
    cursor: pointer;
  }
  .dia_disp:hover {
    font-weight: bold;
    background-color: darkgreen;
    color: #FFF;
  }
      */