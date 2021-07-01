@extends('payments.master')

@section('javascripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Create an instance of the Stripe object
    // Set your publishable API key
    var stripe = Stripe('{{ env("STRIPE_PUBLISH_KEY") }}');

    var style = {
        base: {
            fontWeight: 400,
            fontFamily: '"DM Sans", Roboto, Open Sans, Segoe UI, sans-serif',
            fontSize: '16px',
            lineHeight: '1.4',
            color: '#1b1642',
            padding: '.75rem 1.25rem',
            '::placeholder': {
                color: '#ccc',
            },
        },
        invalid: {
            color: '#dc3545',
        }
    };

    var elements = stripe.elements();
    var cardElement = elements.create('card', { style: style });
    cardElement.mount('#card-element');

    var cardholderName = document.getElementById('cardholder-name');
    var cardButton = document.getElementById('card-button');
    var resultContainer = document.getElementById('card-result');
    var form = document.getElementById('card-form');
    cardButton.addEventListener('click', function(ev) {

    stripe.createPaymentMethod({
        type: 'card',
        card: cardElement,
        billing_details: {
            name: cardholderName.value,
        },
        }
    ).then(function(result) {
        if (result.error) {
        // Display error.message in your UI
        resultContainer.textContent = result.error.message;
        } else {
            // You have successfully created a new PaymentMethod
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'paymentMethodId');
            hiddenInput.setAttribute('value', result.paymentMethod.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    });
    });

</script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1 class="text-center">Stripe Update Card</h1>
            <hr>
            @if (session()->has('error'))
                <div class="text-danger font-italic">{{ session()->get('error') }}</div>
            @endif
            <form action="{{ url('card_update') }}" method="post" id="card-form">
                @csrf
                <input id="cardholder-name" type="text">
                <!-- placeholder for Elements -->
                <div id="card-element"></div>
                <div id="card-result"></div>
                <button id="card-button" type="button">Save Card</button>
            </form>
        </div>
    </div>
@endsection