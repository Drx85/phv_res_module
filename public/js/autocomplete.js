let origin;
let destination;

function initAutocomplete() {
	origin = new google.maps.places.Autocomplete(
		document.getElementById("ask_quote_origin"),
		{
			componentRestrictions: {"country": ["FR"]},
			fields: ["place_id", "geometry", "name"]
		}
	);
	origin.addListener("place_changed", function (e) {
		if (typeof origin.getPlace() !== "undefined") {
			let originPlace = origin.getPlace();
			document.getElementById("ask_quote_originPlaceId").value = originPlace.place_id;
		}
	});
	destination = new google.maps.places.Autocomplete(
		document.getElementById("ask_quote_destination"),
		{
			componentRestrictions: {"country": ['FR']},
			fields: ["place_id", "geometry", "name"]
		}
	);
	destination.addListener("place_changed", function (e) {
		if (typeof destination.getPlace() !== "undefined") {
			let destinationPlace = destination.getPlace();
			document.getElementById("ask_quote_destinationPlaceId").value = destinationPlace.place_id;
		}
	});
}