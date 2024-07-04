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
                    <h2>Cancelar Assinatura</h2>
                    <div class="section">
                        <p>Você está prestes a cancelar sua assinatura. Se você confirmar, sua conta permanecerá ativa até o final do período já pago.</p>
                        <p><strong>Importante:</strong> Você poderá reativar sua conta em até 90 dias após o cancelamento.</p>
                        <p>Deseja <strong>confirmar o cancelamento da sua assinatura</strong>?</p>
                    </div>
                    <div class="buttons">
                        <button class="btn btn-cancel btn-cancel-confirm">Cancelar Assinatura</button>
                        <button class="btn"  onclick="goBack()">Voltar</button>
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
    <script>
        function goBack() {
            window.history.back();
        }

        document.addEventListener("DOMContentLoaded", function() {
            const cancelButton = document.querySelector(".btn-cancel-confirm");

            cancelButton.addEventListener("click", () => {
                alert("Assinatura cancelada com sucesso. Você pode reativar sua conta em até 90 dias.");
                window.location.href = "paypal_account.php";
            });
        });
    </script>
</body>
</html>
