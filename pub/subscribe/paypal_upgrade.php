<?php

require "/etc/winco/cloudvpn_paypal.php";

$price_tiers = [
	// usu (max), valor
	[2, 2.45],
	[5, 2],
	[10, 1.8],
	[15, 1.3],
	[100000, 1.2]
];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar numero de usuários</title>
    <script src="https://www.paypal.com/sdk/js?client-id=<?= PAYPAL_API_KEY; ?>&components=buttons&vault=true&intent=subscription"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="Suscription">
        <div class="container">
            <div class="checkout">
                <div class="left-column">
                    <h2>Alterar numero de usuarios</h2>
                    <div class="section">
                        <h3>Plano atual</h3>
                        <div class="product-container">
                            <div class="svg-icon-wrapper">
                                <img class="svg-icon"
                                    src="data:image/svg+xml, <svg width='40' height='40' viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' clip-rule='evenodd' d='M20.0393 6C26.0511 6 31.1198 10.3343 32.2593 16.1797C36.5815 16.458 40 20.0766 40 24.57C40 29.2224 36.2672 33 31.6699 33H10.0196C4.44008 33 0 28.4271 0 22.8601C0 17.6112 3.92927 13.3166 8.91945 12.7997C11.0413 8.74374 15.2063 6 20.0393 6ZM15.5152 16.2188C17.8728 16.2188 19.8374 17.7299 20.584 19.8374H29.8178V23.4559H28.0889V27.0745H24.5133V23.4559H20.6233C19.8767 25.5634 17.9121 27.0745 15.5545 27.0745C12.6076 27.0745 10.1714 24.6091 10.1714 21.6268C10.1714 18.6445 12.529 16.1791 15.5152 16.2188ZM13.747 21.6665C13.747 22.6606 14.5329 23.4559 15.5152 23.4559C16.4975 23.4559 17.2834 22.6606 17.2834 21.6665C17.2834 20.6724 16.4975 19.8771 15.5152 19.8771C14.5329 19.8771 13.747 20.6724 13.747 21.6665Z' fill='%2336AFE5' /></svg>"
                                    alt="SVG Icon">
                            </div>
                            <p class="product-title">Winco CloudVPN para 2 usuários</p>
                        </div>
                        <div class="subscription-details">
                            <div class="detail-item">
                                <div class="detail-label">Status da Assinatura:</div>
                                <div class="detail-value">Ativa até 20/06/2024</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Preço:</div>
                                <div class="detail-value">US$ 4.90</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Próxima Data de Cobrança:</div>
                                <div class="detail-value">20/05/2024</div>
                            </div>
                        </div>
                    </div>
                    <div class="selection-box section">
                        <h3>Novo Plano</h3>
                        <form method="post">
                            <input type="hidden" name="inst_id" value="<?=@$_REQUEST['inst_id'];?>" />
                            <label for="users">Escolher numero de usuários:</label>
                            <select id="users" name="users">
                                <?php for ($i = 2; $i < 50; $i++): ?>
                                <option value="<?=$i;?>">
                                    <?=$i;?> usuários
                                </option>
                                <?php endfor;?>
                            </select>
                        </form>
                        <div class="total">
                            <span>Total:</span>
                            <span>US$ <span id="preco">US</span></span> 
                        </div>
                    </div>
                    <div class="payment-methods section">
                        <h3>Selecione o método de pagamento</h3>
                        <ul class="nav">
                            <!-- tab1 add more if needed -->
                            <li class="nav-item">
                                <a class="nav-link active" data-method="paypal">PayPal</a>
                            </li>
                            <!-- end of tab1 -->
                        </ul>
                        <!-- tab1 content add more if needed -->
                        <div class="tab-content active" id="paypal">
                            <p><strong>Importante:</strong> O e-mail utilizado para login no portal será o mesmo da
                                sua
                                conta PayPal.</p>
                            <div id="paypal-button-container" style="margin: 5% 0 0 0;"></div>
                        </div>
                        <!-- end of tab1 content -->
                    </div>
                </div>
                <div class="right-column">
                    <div class="support-summary">
                        <h2>Suporte</h2>
                        <div class="faq">
                            <h3>Perguntas Frequentes</h3>
                            <ul>
                                <li>Como alterar o número de usuários?</li>
                                <li>Como cancelar a assinatura?</li>
                                <li>Como visualizar as transações financeiras?</li>
                            </ul>
                        </div>
                        <hr>
                        <div class="contact">
                            <h3>Contato</h3>
                            <small>Para mais informações, visite nossa <a href="https://cloudvpn.winco.com.br/support"
                                    target="_blank">página de contato</a>.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="tabs.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            /*
             * EDUARDO, EDITE AQUI OS NOMES DO CONTROLES SE PRECISAR!!
             */
            window.user_select = document.querySelector('select[name="users"]');
            window.price_span = document.getElementById('preco');
            window.paypal_container_id = 'paypal-button-container';

            paypal.Buttons({
                style: {
                    shape: 'rect',
                    color: 'gold',
                    layout: 'horizontal',
                    label: 'subscribe',
                    tagline: 'false',
                },
                createSubscription(data, actions) {
                    let numPontos = parseInt(window.user_select.value);
                    let custom_id = document.querySelector('input[name="inst_id"]').value;
                    let options = {
                        'plan_id': '<?=PAYPAL_PLAN_ID;?>',
                        'quantity': numPontos
                    };
                    if (custom_id != '')
                        options['custom_id'] = custom_id;

                    return actions.subscription.create(options);
                },

                onApprove(data) {
                    // activating subscription... (must pass at leaast custom_id, email, name and subscriptionID)
                    fetch('on_approve.php?prov=paypal&subscriptionID=' + data.subscriptionID)
                        .then(response => {
                            // Check if the response is ok (status code 200-299)
                            if (!response.ok)
                                throw new Error('Network response was not ok ' + response.statusText);
                            return response.json();
                        })
                        .then(data => {
                            // subscription activated, now go to your email to activate a password.
                            if (data.status == 'ok')
                                alert('Sua assinatura foi criada. Agora faça o login!');
                            else
                                throw new Error('Cannot activate your subscription: ' + data.message);
                        })
                        .catch(error => {
                            // Handle any errors that occurred during the fetch
                            console.error('There was a problem with the fetch operation:', error);
                        });
                }
            }).render('#' + window.paypal_container_id);

            window.user_select.addEventListener('change', update_price);
            update_price();
        });

        function calc_preco(users) {
            let tiers = <?= json_encode($price_tiers); ?>;
            let final_price = 0;
            let current_tier = 0;
            for (let i = 0; users > 0 && i < tiers.length; i++) {
                let inc = tiers[i][0] - current_tier;
                if (inc > users)
                    inc = users;
                final_price += (inc * tiers[i][1]);
                users -= inc;
                current_tier = tiers[i][0];
            }
            return final_price;
        }
        function update_price() {
            let users = window.user_select.value;
            let total_price = calc_preco(users).toFixed(2).replace('.', '.');
            window.price_span.innerHTML = total_price;
            document.getElementById('summary-users').textContent = users;
        }
    </script>
</body>

</html>