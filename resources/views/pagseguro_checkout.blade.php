Obrigado por utilizar nosso sistema. <br>
Você será redirecionado para a página PagSeguro para pagamento com segurança. <br>
Caso não seja redirecionado automaticamente, clique no botão abaixo. <br>
MUNDO VET <br>
<a href="https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code={{$code}}" class="checkout" data-id="{{$code}}">Clique aqui para efetuar o pagamento com segurança na página da PagSeguro</a>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
    $(function(){
        let code = $('.checkout').attr('data-id');
        window.location.href = "https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code="+code;
    })
</script>