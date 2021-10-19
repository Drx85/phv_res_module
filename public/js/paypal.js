window.onload = () => {
	paypal.Buttons({
		// Sets up the transaction when a payment button is clicked
		createOrder: function () {
			return fetch("/create-paypal-transaction", {
				method: "post",
				headers: {
					"content-type": "application/json"
				}
			}).then(function(res) {
				return res.json();
			}).then(function(data) {
				return data.res.result.id;
			});
		},
		// Finalize the transaction after payer approval
		onApprove: function(data, actions) {
			return fetch("/capture-paypal-transaction", {
				method: "post",
				headers: {
					"content-type": "application/json"
				},
				body: JSON.stringify({
					orderID: data.orderID
				})
			}).then(function(res) {
				return res.json();
			}).then(function(details) {
				if (details.res.statusCode !== 201) {
					alert("Le paiement a échoué. Veuillez réessayer.");
					return actions.restart();
				}
				window.location.replace("/confirmation");
			});
		}
	}).render("#paypal-button-container");
};