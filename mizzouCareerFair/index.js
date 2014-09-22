//Javascript for Index
	function submitFilter()
	{
		//Check to make sure a major has been selected
		var filter = new Array();
		for (i=0; i < 8 ; i++)
		{
			filter[i] = document.getElementById('filter_'+i);
		}
		//Submit Form
		if (filter[0].checked || filter[1].checked || filter[2].checked || filter[3].checked || 
		filter[4].checked || filter[5].checked || filter[6].checked || filter[7].checked)
		{
			document.getElementById("filterForm").submit();
			window.alert("You're Settings have been saved.");
		}
		else {
		alert("ERROR: Please Select a Major");
		}
	}
	
	$(document).on("pageinit", "#map_page", function() {
		initialize();
	});

	$(document).on('click', '#submit', function(e) {
		e.preventDefault();
		calculateRoute();
	});

	var directionDisplay,
		directionsService = new google.maps.DirectionsService(),
		map;

	function initialize() 
	{
		directionsDisplay = new google.maps.DirectionsRenderer();
		var mapCenter = new google.maps.LatLng(38.9343, -92.3306);

		var myOptions = {
			zoom:10,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: mapCenter
		}

		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		directionsDisplay.setMap(map);
		directionsDisplay.setPanel(document.getElementById("directions"));

		
		
		navigator.geolocation.getCurrentPosition(showPosition);
		var latlon;
		
		function showPosition(pos) {
			var latlon = pos.coords.latitude+","+pos.coords.longitude;
			console.log(latlon);
			
			$('#from').val(latlon);
		};
	}
	
	function calculateRoute() 
	{
		var x = document.getElementById("map_canvas");
		
		navigator.geolocation.getCurrentPosition(showPosition);
		var latlon;
		
		function showPosition(pos) {
			var latlon = pos.coords.latitude+","+pos.coords.longitude;
			console.log(latlon);
			
		};
			
	
	
		var selectedMode = $("#mode").val(),
			start = $("#from").val(),
			end = $("#to").val();

		if(start == '' || end == '')
		{
			// cannot calculate route
			$("#results").hide();
			return;
		}
		else
		{
			var request = {
				origin:start, 
				destination:end,
				travelMode: google.maps.DirectionsTravelMode[selectedMode]
			};

			directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response); 
					$("#results").show();
					/*
						var myRoute = response.routes[0].legs[0];
						for (var i = 0; i < myRoute.steps.length; i++) {
							alert(myRoute.steps[i].instructions);
						}
					*/
				}
				else {
					$("#results").hide();
				}
			});

		}
	}
