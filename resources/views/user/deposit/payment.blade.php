@extends('layouts.user')
@section('title')
    @langg('Confirm Deposit')
@endsection

@section('content')
<section class="user-panel pt-100 pb-100">
    <div class="container">
        <div class="card shadow-md mb-4">
            <div class="card-header text-center bg-white p-4">
                <h4>@langg('Payment Details')</h4>
            </div>
            <div class="card-body">
                @if (Session::has('errors'))
                <div class="mt-3 pb-0">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{Session::get('errors')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div> 
                @endif
                <form action="{{route('user.deposit.payment')}}" method="POST" id="{{Session::get('deposit_data')['keyword']}}" >
                    @csrf
                    <div class="text-center">
                        <strong>@langg('Total Payment') : {{$currency->symbol.$deposit_data['amount']}}</strong><br>
                        @if ($charge)
                        <strong>@langg('Total Charge') : {{$currency->symbol.numFormat($charge,2)}}</strong>
                        @endif
                      <br>  <strong>@langg('Payment Method') : {{$gateway->name}}</strong>
                        <input type="hidden" name="currency" value="{{$currency->id}}">
                        <hr class="mt-5">
                        @include('other.payment_load')

                    </div>
                        <div class="text-end my-4">
                            <button type="submit" id="payment__button" class="cmn--btn w-100">@langg('Submit')</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</section>

   

@php
    $paystack = [];
    if(Session::get('deposit_data')['keyword'] == 'paystack'){
        $paystack = $gateway->convertAutoData();
    }
    if(Session::get('deposit_data')['keyword'] == 'mercadopago'){
        $paydata = $gateway->convertAutoData();
    }
@endphp
@endsection

@push('script')
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        'use strict'
   $(document).on('submit','#paystack',function(){
                var total = {{Session::get('deposit_data')['amount']}};
                total = Math.round(total);
                var handler = PaystackPop.setup({
                key: '{{ isset($paystack["key"]) ? $paystack["key"] : '' }}',
                email: '{{ Auth::user()->email }}',
                amount: total * 100,
                currency: "{{ getCurrencyCode() }}",
                ref: ''+Math.floor((Math.random() * 1000000000) + 1),
                    callback: function(response){
                        $('#ref_id').val(response.reference);
                        $('#paystack').attr('id','');
                        $('#payment__button').click();
                    },
                    onClose: function(){
                        window.location.reload();
                    }
                });
                handler.openIframe();
                 return false;
		});
    </script> 
@if(Session::get('deposit_data')['keyword'] == 'mercadopago')
<script>
    'use strict';

    window.Mercadopago.setPublishableKey("{{ $paydata['public_key'] }}");
    window.Mercadopago.getIdentificationTypes();

    function addEvent(to, type, fn){ 
      if(document.addEventListener){
          to.addEventListener(type, fn, false);
      } else if(document.attachEvent){
          to.attachEvent('on'+type, fn);
      } else {
          to['on'+type] = fn;
      }  
  }; 

addEvent(document.querySelector('#cardNumber'), 'keyup', guessingPaymentMethod);
addEvent(document.querySelector('#cardNumber'), 'change', guessingPaymentMethod);

function getBin() {
  var ccNumber = document.querySelector('input[data-checkout="cardNumber"]');
  return ccNumber.value.replace(/[ .-]/g, '').slice(0, 6);
};

function guessingPaymentMethod(event) {
  var bin = getBin();

  if (event.type == "keyup") {
      if (bin.length >= 6) {
          window.Mercadopago.getPaymentMethod({
              "bin": bin
          }, setPaymentMethodInfo);
      }
  } else {
      setTimeout(function() {
          if (bin.length >= 6) {
              window.Mercadopago.getPaymentMethod({
                  "bin": bin
              }, setPaymentMethodInfo);
          }
      }, 100);
  }
};

function setPaymentMethodInfo(status, response) {
  if (status == 200) {
      const paymentMethodElement = document.querySelector('input[name=paymentMethodId]');

      if (paymentMethodElement) {
          paymentMethodElement.value = response[0].id;
      } else {
          const input = document.createElement('input');
          input.setAttribute('name', 'paymentMethodId');
          input.setAttribute('type', 'hidden');
          input.setAttribute('value', response[0].id);     

          form.appendChild(input);
      }

      Mercadopago.getInstallments({
          "bin": getBin(),
          "amount": parseFloat(document.querySelector('#amount').value),
      }, setInstallmentInfo);

  } else {
      alert(`payment method info error: ${response}`);  
  }
};



addEvent(document.querySelector('#mercadopago'), 'submit', doPay);
function doPay(event){
  event.preventDefault();

      var $form = document.querySelector('#mercadopago');

      window.Mercadopago.createToken($form, sdkResponseHandler); // The function "sdkResponseHandler" is defined below

      return false;
  
};

function sdkResponseHandler(status, response) {
  if (status != 200 && status != 201) {
      alert("Some of your information is wrong!");
      $('#preloader').hide();

  }else{
      var form = document.querySelector('#mercadopago');
      var card = document.createElement('input');
      card.setAttribute('name', 'token');
      card.setAttribute('type', 'hidden');
      card.setAttribute('value', response.id);
      form.appendChild(card);
 
      form.submit();
  }
};


function setInstallmentInfo(status, response) {
      var selectorInstallments = document.querySelector("#installments"),
      fragment = document.createDocumentFragment();
      selectorInstallments.length = 0;

      if (response.length > 0) {
          var option = new Option("Escolha...", '-1'),
          payerCosts = response[0].payer_costs;
          fragment.appendChild(option);

          for (var i = 0; i < payerCosts.length; i++) {
              fragment.appendChild(new Option(payerCosts[i].recommended_message, payerCosts[i].installments));
          }

          selectorInstallments.appendChild(fragment);
          selectorInstallments.removeAttribute('disabled');
      }
  };



</script>
@endif
@endpush