window.onload = () => {
	paypal.Buttons({
		// Sets up the transaction when a payment button is clicked
		createOrder: function () {
			return fetch('/create-paypal-transaction', {
				method: 'post',
				headers: {
					'content-type': 'application/json'
				}
			}).then(function(res) {
				return res.json();
			}).then(function(data) {
				return data.res.result.id; // Use the key sent by your server's response, ex. 'id' or 'token'
			});
		},
		// Finalize the transaction after payer approval
		onApprove: function(data) {
			return fetch('/capture-paypal-transaction', {
				method: 'post',
				headers: {
					'content-type': 'application/json'
				},
				body: JSON.stringify({
					orderID: data.orderID
				})
			}).then(function(res) {
				return res.json();
			}).then(function(details) {
				alert('Transaction funds captured from ' + details.payer_given_name);
			})
		}
	}).render('#paypal-button-container');
}