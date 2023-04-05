@extends('layouts.frontend')

@section('title')
    @langg('API Documentation')
@endsection


@section('content')
      <!-- Documentation -->
      <section class="documentation-section pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="documentation-wrapper">
                        <div class="documentation-item" id="intro">
                            <div class="documentation-header">
                                <h3 class="title">@langg('API Endpoints & Authentication')</h3>
                               
                            </div>
                            <p>
                               @langg(' All requests to the') {{$gs->title}} @langg('API are sent via the HTTP POST method to one of our API endpoint URLs').

                                <ul>
                                    <li>
                                        @langg('HTTP Request Method') : <span class="badge badge--primary">POST</span>
                                    </li>
                                    <li class="mt-2">
                                        @langg('API Endpoint') : <a href="javascript:void(0)">{{url('payment/process')}}</a>
                                    </li>
                                    <li class="my-2">
                                        @langg('JSON Content-Type') : <span class="badge badge--warning">application/json</span>
                                    </li>
                                </ul>

                                @langg('All calls to the') {{$gs->title}} @langg('API require merchant authentication and merchant access key.') <a href="{{url('merchant/register')}}">@langg('Sign up')</a> @langg('for a  account to quickly get started').
                                <br>
                                @langg('Sandbox payment can be also initiated while merchant set the service mode as test in merchant dashboard. It will be live while the mode will be set as active mode.')
                            </p>
                          
                        </div>

                        <div class="documentation-item" id="api">
                            <div class="documentation-header">
                                <h3 class="title">@langg('API Access Key')</h3>
                            </div>
                            <p>
                               @langg('Register as a merchant in our system. In your merchant dashboard you will find the option for API access key.') <br><br>

                               @langg('Example access key : 51a4bd18-5bc1-4eaa-97b0-c09323398883')
                            </p>
                            
                        </div>

                        
                        <div class="documentation-item" id="payment">
                            <div class="documentation-header">
                                <h3 class="title">@langg('Payment Transaction Initiate')</h3>
                            </div>
                            <p>
                                @langg('The following example code enables you to initiate a payment,depending on how you structure it. The perameter details are also below.')
                            </p>

                            <table class="table table-bordered text-center bg--section mb-4">
                                <thead class="bg--base">
                                    <tr>
                                        <th class="text--white">@langg('Param Name')</th>
                                        <th class="text--white">@langg('Param Type')</th>
                                        <th class="text--white">@langg('Description')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            @langg('custom')
                                        </td>
                                        <td>
                                            @langg('string')
                                        </td>
                                        <td>
                                            @langg('Identification of your end') <span class="badge badge--danger">@langg('Required')</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @langg('amount')
                                        </td>
                                        <td>
                                            @langg('decimal')
                                        </td>
                                        <td>
                                            @langg('The amount you want to transaction') <span class="badge badge--danger">@langg('Required')</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @langg('details')
                                        </td>
                                        <td>
                                            @langg('string')
                                        </td>
                                        <td>
                                            @langg('Purchase details') <span class="badge badge--danger">@langg('Required')</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @langg('web_hook')
                                        </td>
                                        <td>
                                            @langg('string')
                                        </td>
                                        <td>
                                            @langg('Instant payment notification url') <span class="badge badge--danger">@langg('Required')</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @langg('cancel_url')
                                        </td>
                                        <td>
                                            @langg('string')
                                        </td>
                                        <td>
                                            @langg('Payment cancel return url') <span class="badge badge--danger">@langg('Required')</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @langg('success_url')
                                        </td>
                                        <td>
                                            @langg('string')
                                        </td>
                                        <td>
                                            @langg('Payment success return url') <span class="badge badge--danger">@langg('Required')</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @langg('customer_email')
                                        </td>
                                        <td>
                                            @langg('string')
                                        </td>
                                        <td>
                                            @langg('Customer email address') <span class="badge badge--danger">@langg('Required')</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @langg('access_key')
                                        </td>
                                        <td>
                                            @langg('string')
                                        </td>
                                        <td>
                                            @langg('Send access_key as bearer token with header') <span class="badge badge--danger">@langg('Required')</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <pre class="mb-0">
                                <button class="copy-btn" data-clipboard-target="#php-code">@langg('Copy')</button>
    <code class="language-php" id="php-code">
            &lt;?php
                $parameters = [
                    'custom' => 'DFU80XZIKS',
                    'currency_code' => 'USD',
                    'amount' => 280.00,
                    'details' => 'Digital Product',
                    'web_hook' => 'http://yoursite.com/web_hook.php',
                    'cancel_url' => 'http://yoursite.com/cancel_url.php',
                    'success_url' => 'http://yoursite.com/success_url.php',
                    'customer_email' => 'customer@mail.com',
                ];
                
                $url = 'http://yourwallet.com/payment/process';
                
                $headers = [
                    "Accept: application/json",
                    "Authorization: Bearer access_key",
                ];
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($parameters));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
            ?&gt;
    </code>
                            </pre>
                            
                        </div>

                        <div class="documentation-item" id="payment">
                            <div class="documentation-header">
                                <h3 class="title">@langg('Example Response after initiating payment')</h3>
                            </div>
                            <pre class="mb-0">
                                
        <code class="language-php" id="php-code">
        
            //Success Response.
            {
                "code": 200,
                "status": "ok",
                "payment_id": "AIYmQIOAz0GlmsjfhgiOeu304",
                "message": "Your payment has been processed. Please follow the URL to complete the payment.",
                "url":"{{url('/')}}/process-checkout?payment_id=AIYmQIOAz0GlmsjfhgiOeu304"
            }

            //Error Response.
            {
                "code": 401,
                "status": "error",
                "message": "Invalid API credentials."
            }
            
            
        </code>
                            </pre>
                            
                        </div>

                        <div class="documentation-item" id="payment">
                            <div class="documentation-header">
                                <h3 class="title">@langg('Response after successful payment')</h3>
                            </div>
                            <pre class="mb-0">
                                
        <code class="language-php" id="php-code">
        
            //Success Response.
            {
                "code": 200,
                "status": "ok",
                "payment_id": "AIYmQIOAz0GlmsjfhgiOeu304",
                "transaction": "AIYmQIOAz0G",
                "amount": 100.00,
                "charge": 5.00,
                "currency": "USD",
                "custom": "BVSUZ545XCS",
                "date"  : "22-05-2022"
            }

            
        </code>
                            </pre>
                            
                        </div>
                       


                        <div class="documentation-item" id="payment">
                            <div class="documentation-header">
                                <h3 class="title">@langg('Verify Payment')</h3>
                            </div>
                            <p>
                                @langg('You can verify the payment whether it is valid or not. After successful payment transaction you will have the response where you find the Payment ID. With this payment id and your access key you need make a request to our server for verify the payment. Example code is below. ')<br>  <br>
                                <span>@langg('Payment verify end point : ') <a href="javascript:void(0)">{{url('payment/check-validity')}}</a></span>
                            </p> 

                            <pre class="mb-0">
                                <button class="ver-btn copy-btn" data-clipboard-target="#ver-code">@langg('Copy')</button>
    <code class="language-php" id="ver-code">
            &lt;?php
                $parameters = [
                    'payment_id' => 'AIYmQIOAz0GlmsjfhgiOeu304',
                ]
                
                $url = '{{url('payment/check-validity')}}';
                
                $headers = [
                    "Accept: application/json",
                    "Authorization: Bearer access_key",
                ];
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS,  $parameters);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
            ?&gt;
    </code>
                            </pre>
                            
                        </div>

                        <div class="documentation-item" id="payment">
                            <div class="documentation-header">
                                <h3 class="title">@langg('Validity Response')</h3>
                            </div>
                            <pre class="mb-0">
                                
        <code class="language-php" id="php-code">
        
            //Success Response.
            {
                "code": 200,
                "status": "ok",
                "message": "Transaction is valid",
                
            }

            //Error Response.
            {
                "code": 401,
                "status": "error",
                "message": "Invalid API credentials."
            }

            //or
            {
                "code": 404,
                "status": "error",
                "message": "Transaction not found"
            }

            
        </code>
                            </pre>
                            
                        </div>

                         <div class="documentation-item" id="currency">
                            <div class="documentation-header">
                                <h3 class="title">@langg('Supported Currencies')</h3>
                            </div>
                            <p>
                                @langg('Following currencies are currently supported in our system. It may update furthur.')
                            </p>
                            <table class="table table-bordered text-center bg--section mb-0">
                                <thead class="bg--base">
                                    <tr>
                                        <th class="text--white">@langg('Currency Name')</th>
                                        <th class="text--white">@langg('Currency Symbol')</th>
                                        <th class="text--white">@langg('Currency Code')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($currencies as $item)
                                        <tr>
                                            <td>
                                               {{$item->curr_name}}
                                            </td>
                                            <td>
                                                {{$item->symbol}}
                                            </td>
                                            <td>
                                                {{$item->code}}
                                            </td>
                                        </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Documentation -->

@endsection

@push('script')
<script src="{{asset('assets/frontend')}}/js/highlight.min.js"></script>
<script>
    hljs.highlightAll();
</script>

<script src="{{asset('assets/frontend')}}/js/clipboard.min.js"></script>
<script>
    new ClipboardJS('.copy-btn');
    new ClipboardJS('.ver-btn');
</script>
@endpush