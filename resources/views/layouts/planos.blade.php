



            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title flex-direct-column">Seja bem vindo ao MundoVet</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

              <div class="row justify-content-between mb-3 box-plans">

                <div class="col-md-3 m-3 p-3 plans">
                  <p style="font-weight: bold;">Plano de 30 dias</p>
                  <p style="text-decoration: line-through;">De R$ 69,00</p>
                  <p>Por R$ {{number_format(69.00 * 0.95, 2, ',', '.')}}</p>
                  <p>5% de desconto</p>
                  <form class="form-horizontal" method="POST" action="{{ route( 'pagseguro_autorization' ) }}">
                      @csrf
                    <input type="hidden" name="company_id" value="{{$company->id}}">
                    <input type="hidden" name="company_email" value="{{$company->email}}">
                    <input type="hidden" name="item_id" value="30">
                    <input type="hidden" name="item_description" value="Plano30dias">
                    <input type="hidden" name="item_amount" value="65.55">
                    <input type="submit" class="btn btn-primary" id="plano30" value="Renovar Agora">
                  </form>
                </div>

                <div class="col-md-3 m-3 p-3 plans">
                  <p style="font-weight: bold;">Plano de 6 meses</p>
                  <p style="text-decoration: line-through;">De R$ 419,00</p>
                  <p>Por R$ {{number_format(419.00 * 0.9, 2, ',', '.')}}</p>
                  <p>10% de desconto</p>
                  <form class="form-horizontal" method="POST" action="{{ route( 'pagseguro_autorization' ) }}">
                    @csrf
                    <input type="hidden" name="company_id" value="{{$company->id}}">
                    <input type="hidden" name="company_email" value="{{$company->email}}">
                    <input type="hidden" name="item_id" value="180">
                    <input type="hidden" name="item_description" value="Plano180dias">
                    <input type="hidden" name="item_amount" value="377.10">
                    <a class="btn btn-primary" id="plano180" href="">Renovar agora</a>
                  </form>
                </div>
                
                <div class="col-md-3 m-3 p-3 plans">
                  <p style="font-weight: bold;">Plano de 1 ano</p>
                  <p style="text-decoration: line-through;">De R$ 838,00</p>
                  <p>Por R$ {{number_format(838.00 * 0.8, 2, ',', '.')}}</p>
                  <p>20% de desconto</p>
                  <form class="form-horizontal" method="POST" action="{{ route( 'pagseguro_autorization' ) }}">
                    @csrf
                    <input type="hidden" name="company_id" value="{{$company->id}}">
                    <input type="hidden" name="company_email" value="{{$company->email}}">
                    <input type="hidden" name="item_id" value="365">
                    <input type="hidden" name="item_description" value="Plano365dias">
                    <input type="hidden" name="item_amount" value="670.40">
                    <a class="btn btn-primary" id="plano365" href="">Renovar agora</a>
                  </form>
                </div>

                <div class="vencimento-area p-3">
                  @if ($dados_vencimento['venc'] < $dados_vencimento['hoje'])
                    {{date('d/m/Y', strtotime($dados_vencimento['venc']))}} - <small>Vencido a {{$dados_vencimento['dias']}} dia{{(($dados_vencimento['dias']>1)) ? 's' : ''}}!</small> 
                  @elseif($dados_vencimento['venc'] == $dados_vencimento['hoje'])
                    {{date('d/m/Y', strtotime($dados_vencimento['venc']))}} - <small>Vence hoje!</small> 
                  @else
                    Vencimento:
                    {{date('d/m/Y', strtotime($dados_vencimento['venc']))}} - <small>Você ainda tem {{$dados_vencimento['dias']}} dia{{(($dados_vencimento['dias']>1)) ? 's' : ''}}!</small> 
                    <div class="progress progress-xs">
                      <div class="progress-bar" style="background-color:#B40404;width: {{$dados_vencimento['percent']}}%"></div>
                    </div>
                  @endif
                </div>
              </div>

            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light bg-danger" data-dismiss="modal">Agora não</button>
              <small>OBS: Você pode renovar a qualquer momento no menu Perfil Empresa > Renovação do Sistema</small>
            </div>