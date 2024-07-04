<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações da Assinatura</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="Suscription">
        <div class="container">
            <div class="checkout">
                <div class="left-column">
                    <h2>Informações da Assinatura</h2>
                    <div class="section">
                        <div class="product-container">
                            <div class="svg-icon-wrapper">
                                <img class="svg-icon" src="data:image/svg+xml, <svg width='40' height='40' viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' clip-rule='evenodd' d='M20.0393 6C26.0511 6 31.1198 10.3343 32.2593 16.1797C36.5815 16.458 40 20.0766 40 24.57C40 29.2224 36.2672 33 31.6699 33H10.0196C4.44008 33 0 28.4271 0 22.8601C0 17.6112 3.92927 13.3166 8.91945 12.7997C11.0413 8.74374 15.2063 6 20.0393 6ZM15.5152 16.2188C17.8728 16.2188 19.8374 17.7299 20.584 19.8374H29.8178V23.4559H28.0889V27.0745H24.5133V23.4559H20.6233C19.8767 25.5634 17.9121 27.0745 15.5545 27.0745C12.6076 27.0745 10.1714 24.6091 10.1714 21.6268C10.1714 18.6445 12.529 16.1791 15.5152 16.2188ZM13.747 21.6665C13.747 22.6606 14.5329 23.4559 15.5152 23.4559C16.4975 23.4559 17.2834 22.6606 17.2834 21.6665C17.2834 20.6724 16.4975 19.8771 15.5152 19.8771C14.5329 19.8771 13.747 20.6724 13.747 21.6665Z' fill='%2336AFE5' /></svg>" alt="SVG Icon">
                            </div>
                            <p class="product-title">Winco CloudVPN para <span id="summary-users">2</span> usuários</p>
                        </div>
                        <div class="subscription-details">
                            <div class="detail-item">
                                <div class="detail-label">Status da Assinatura:</div>
                                <div class="detail-value">Ativa até 20/06/2024</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Próxima Data de Cobrança:</div>
                                <div class="detail-value">20/05/2024</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Data de Início do Plano:</div>
                                <div class="detail-value"><span id="number-of-users">01/01/2024</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="section">
                        <h3>Transações Financeiras</h3>
                            <table class="table-striped">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Descrição</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>01/02/2024</td>
                                        <td>Pagamento Mensal</td>
                                        <td>R$100,00</td>
                                    </tr>
                                    <tr>
                                        <td>01/03/2024</td>
                                        <td>Pagamento Mensal</td>
                                        <td>R$100,00</td>
                                    </tr>
                                    <tr>
                                        <td>01/04/2024</td>
                                        <td>Pagamento Mensal</td>
                                        <td>R$100,00</td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>

                    <div class="buttons">
                        <button class="btn"  onclick="window.location.href='paypal_upgrade.php';">Alterar Número de Usuários</button>
                        <button class="btn btn-cancel" onclick="window.location.href='paypal_cancel_subscription.php';">Cancelar Assinatura</button>
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
                            <small>Para mais informações, visite nossa <a href="https://cloudvpn.winco.com.br/support" target="_blank">página de contato</a>.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
