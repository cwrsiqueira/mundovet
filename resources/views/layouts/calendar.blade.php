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
  #year {
    border: 0;
    text-align: center;
  }
</style>

<div class="container">

  <div class="d-flex row p-2 m-2">

    <div class="col-md">
      <select class="form-control" name="select_month" id="select_month">
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

      <input type="text" name="year" id="year" value="{{$dados['a']}}">

      <div class="col-sm d-flex justify-content-center" id="year_plus">
        <i class="fas fa-angle-double-right"></i>
      </div>
      
    </div>
  </div>

  <div id="calendar">
    <table class="table" id="table_calendar">
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
      <tbody></tbody> 
    </table>
  </div>
  
  <div class="d-flex justify-content-start m-2 p-2 align-items-center">
    <div class="box-legenda m-1"></div>
    <div class="texto-legenda">Dias Disponíveis</div>
  </div>
</div>

<script src="{{asset('/vendor/jquery/jquery.min.js')}}"></script>
<script>

  // Incluir data e hora selecionados, nos devidos campos
  $('#hr_retorno').change(function(){
    let hora = $(this).val();
    let day = $('#data_retorno').val().split(' ');
    $('#data_retorno').val(day[0]+' '+hora+':00:00');
  })

  // Inserir os horários disponíveis baseados na data selecionada
  let a, m, d = 0;
  
  function selectDate(a,m,d) {
    let data_marcada_mostrar = ("0"+d).slice(-2)+' / '+("0"+m).slice(-2)+' / '+a;
    $('#dt_retorno').val(data_marcada_mostrar);
    $('#data_retorno').val(a+'-'+m+'-'+d);
    $('#hr_retorno').attr('required', 'required');
    $('#modal_calendar').modal('hide');

    $.ajax({
        url:"{{ route('selecionarHorariosDisponiveis') }}",
        type:"get",
        data: {dia:d,mes:m,ano:a},
        success:function(res) {
          console.log(res);
          html = '<option value="">Selecione um horário</option>';
          for (let i = 0; i < res['hd'].length; i++) {
            let dado = res['hd'][i];
            result = dado.split(':');
            html += '<option value="'+result[0]+'">'+result[0]+':'+result[1]+'</option>';
          }
          $('#hr_retorno').html(html);

        }
    });
  }

  $(function(){

    let month = $('#select_month option:selected').val(); 
    let year = $('#year').val();
    let html = makeCalendar(month, year);
    $('#calendar tbody').html(html);

    $('#year').keyup(function(){
      if ($(this).val().length >= 4) {
        year = $('#year').val();
        month = $('#select_month option:selected').val();
        $('#year').val(year);
        html = makeCalendar(month, year);
        $('#calendar tbody').html(html);
        $('#year').blur();
      }
    })

    $('#select_month').change(function(){
      month = $('#select_month option:selected').val();
      html = makeCalendar(month, year);
      $('#calendar tbody').html(html);
    })

    $('#year_less').click(function(){
      month = $('#select_month option:selected').val();
      year--;
      $('#year').val(year);
      html = makeCalendar(month, year);
      $('#calendar tbody').html(html);
    })

    $('#year_plus').click(function(){
      month = $('#select_month option:selected').val();
      year++;
      $('#year').val(year);
      html = makeCalendar(month, year);
      $('#calendar tbody').html(html);
    })

    function makeCalendar(month, year) {

      let date = new Date();
      let dia = ("0" + date.getDate()).slice(-2);
      let mes = ("0" + (date.getMonth() + 1)).slice(-2);
      let ano = date.getFullYear();
      let hoje = ano+'-'+mes+'-'+dia;
      let a = year; 
      let m = ("0" + month).slice(-2);
      let numero_dias = GetNumeroDias(month,year);
      let diacorrente = '<?=$dados['diacorrente']?>';
      let semana_chamada = new Date(a+'-'+m+'-01 00:00:00');
      let diasemana = semana_chamada.getDay();
      let dt_disp = $.parseJSON('<?=$dados['dt_disp']?>');
      let dt_except = $.parseJSON('<?=$dados['dt_except']?>');
      let html = '';
      let exclude_date = [];

      function GetNumeroDias( month, year )
      {
        let numero_dias = new Array(
          31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31
        );
      
        if ((year % 4 == 0) && ((year % 100 != 0) || (year % 400 == 0))) {
            numero_dias[1] = 29;  // altera o numero de dias de fevereiro se o ano for bissexto
        }
        
        return numero_dias[month-1];
      }
      
      for (let linha = 0; linha < 6; linha++) {
        
        html += '<tr>';

          for (let coluna = 0; coluna < 7; coluna++) {
            
            html += '<td';

            if ( (diacorrente + 1) <= numero_dias ) {
              
              if ( coluna < diasemana && linha == 0 ) {
                
              } else {

                let datacorrente = a+'-'+m+'-'+("0" + (diacorrente + 1)).slice(-2);
                if ( datacorrente > hoje ) {
                  
                let d_sem = new Date(datacorrente + ' 00:00:00');
                let d_semm = d_sem.getDay();
                  
                let dias = new Array(
                  'sun','mon','tue','wed','thu','fri','sat'
                );
                let dia_semana = dias[d_semm];
                  
                  dt_disp.forEach(dtd => {

                    if ( dtd.day == dia_semana && dtd.ini_atend > '00:00:00' ) {
                      
                      if (dt_except.length > 0) {
                        
                        dt_except.forEach(dte => {
                          
                          if (datacorrente >= dte.ini_date && datacorrente <= dte.fin_date) {
                            
                            exclude_date.push(datacorrente);

                          }

                        });

                      }

                      if ($.inArray(datacorrente, exclude_date) > -1) {
                        
                      } else {
                        html += " class='dia_disp' onclick='selectDate("+a+","+m+","+(diacorrente+1)+");' ";
                      }

                    }

                  });
                  
                }
              }
            }

            if (diacorrente + 1 == dia && mes == m && ano == a) {
  
              html += " id='dia_atual' ";

            } else {

              if ( (diacorrente + 1) <= numero_dias ) {
  
                if ( coluna < diasemana && linha == 0 ) {
                  html += " id='dia_branco' ";
                } else {
                  html += " id='dia_comum' ";
                }
                  
              } else {
                
                html += " style='display: none;' ";

              }
            }

            html += ">";

            if ( (diacorrente + 1) <= numero_dias ) {
                  
              if ( coluna < diasemana && linha == 0 ) {
                  
              } else {
                  
                  ++diacorrente;
                  html += diacorrente;
                  
              }
              
              html += "</td>";

            }

          }

          html += "</tr>";

      }

      return html;
  
    }

  })

  

</script>
