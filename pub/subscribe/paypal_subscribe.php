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
<html>
<head>
	<meta charset="UTF-8">
	<title>Assinar a Cloud VPN</title>
	<script src="https://www.paypal.com/sdk/js?client-id=<?= PAYPAL_API_KEY; ?>&components=buttons&vault=true&intent=subscription"></script>
</head>
<body>
	<h1>Subscribe to Cloud VPN</h1>
	<h2>(monthly price, charged by PayPal)</h2>
	<form method="post">
		<input type="hidden" name="inst_id" value="<?=@$_REQUEST['inst_id'];?>" />
		<h2>Please select the number of computers</h2>
			<select name="users">
			<?php for ($i = 2; $i < 50; $i++): ?>
				<option value="<?=$i;?>"><?=$i;?> computers</option>
			<?php endfor;?>
			</select>
			US$ <span id="preco">25.00</span>
		<div id="paypal-button-container" style="margin: 0 5%;"></div>
	</form>
	<script>
		document.addEventListener('DOMContentLoaded', () => {
			/*
			 * EDUARDO, EDITE AQUI OS NOMES DO CONTROLES SE PRECISAR!!
			 */
			window.user_select 			= document.querySelector('select[name="users"]');
			window.price_span  			= document.getElementById('preco');
			window.paypal_container_id	= 'paypal-button-container';

			paypal.Buttons({
				style: {
					shape: 'rect',
					color: 'gold',
					layout: 'vertical',
					label: 'subscribe'
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
					fetch('on_approve.php?prov=paypal&subscriptionID='+data.subscriptionID)
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
								throw new Error('Cannot activate your subscription: '+ data.message);
						})
						.catch(error => {
							// Handle any errors that occurred during the fetch
							console.error('There was a problem with the fetch operation:', error);
						});
				}
			}).render('#'+window.paypal_container_id);

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
		function update_price(p) {
			window.price_span.innerHTML = calc_preco(window.user_select.value).toFixed(2).replace('.', '.');
		}
	</script>
</body>
</html>