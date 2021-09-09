{extends file='page.tpl'}



{block name="page_content"}
    <section class="stripe-form">
    <form action="{$link}" method="POST" id="paymentFrm">
        <div class="panel-heading">
            <h2 class="panel-title">Informations de votre carte</h2>
        </div>
        <input name='id_abonnement' type="hidden" value="{$id_abonnement}" class="hidden" />
        <div class="panel-body">
            <!-- Display errors returned by createToken -->
            <div id="paymentResponse"></div>

            <!-- Payment form -->
            <div class="form-group">
                <label>Numéro de carte</label>
                <div id="card_number" class="field"></div>
            </div>
            <div class="form-group">
                <label>Date d'expiration</label>
                <div id="card_expiry" class="field"></div>
            </div>
            <div class="form-group">
                <label>Code CVC</label>
                <div id="card_cvc" class="field"></div>
            </div>
            <button type="submit" class="btn btn-primary" id="payBtn">Valider</button>
        </div>
    </form>
    </section>

    <script src="https://js.stripe.com/v3/"></script>
    <script>

        var stripe = Stripe('{$public_key}');

        // Create an instance of elements
        var elements = stripe.elements();


        var cardElement = elements.create('cardNumber', {
        });
        cardElement.mount('#card_number');

        var exp = elements.create('cardExpiry', {
        });
        exp.mount('#card_expiry');

        var cvc = elements.create('cardCvc', {
        });
        cvc.mount('#card_cvc');

        // Validate input of the card elements
        var resultContainer = document.getElementById('paymentResponse');
        cardElement.addEventListener('change', function(event) {
            if (event.error) {
                resultContainer.innerHTML = '<p>'+event.error.message+'</p>';
            } else {
                resultContainer.innerHTML = '';
            }
        });

        // Get payment form element
        var form = document.getElementById('paymentFrm');

        // Create a token when the form is submitted.
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            createToken();
        });

        // Create single-use token to charge the user
        function createToken() {
            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
                } else {
                    // Send the token to your server
                    stripeTokenHandler(result.token);
                }
            });
        }

        // Callback to handle the response from stripe
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>

{/block}