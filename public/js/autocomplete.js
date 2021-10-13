let origin;
let destination;

function initAutocomplete() {
	origin = new google.maps.places.Autocomplete(
		document.getElementById("origin"),
		{
			componentRestrictions: {'country': ['FR']},
			fields: ['place_id', 'geometry', 'name']
		}
	);
	origin.addListener("place_changed", function (e) {
		document.getElementById("destination").disabled = false;
	});
	
	destination = new google.maps.places.Autocomplete(
		document.getElementById('destination'),
		{
			componentRestrictions: {'country': ['FR']},
			fields: ['place_id', 'geometry', 'name']
		}
	);
	destination.addListener("place_changed", onPlaceChanged);
}

function onPlaceChanged() {
	let originPlace = origin.getPlace();
	let destinationPlace = destination.getPlace();
	
	if (!originPlace.geometry) {
		document.getElementById("origin").placeholder = "Entrez un lieu de départ";
	}
	if (!destinationPlace.geometry) {
		document.getElementById("destination").placeholder = "Entrez une destination";
	} else {
		document.getElementById("validate").innerHTML = '<a href="/quote/' + originPlace.place_id + '/' + destinationPlace.place_id + '">Valider</a>';
	}
}