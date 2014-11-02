
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
		alert("Error: Please Select a Major");
		}
	}
	
	// $(document).on("pageinit", "#map_page", function() {
	
	function nowRun(){
		initialize();
		$("#map_canvas").hide();
		
		
		$('#toggleMap').change(function() {
    		var myswitch = $(this);
    		var show = myswitch[0].selectedIndex == 1 ? true:false;
    
    		if(show) {
				$('#map_canvas').fadeIn('slow');
				google.maps.event.trigger(map, "resize");
				map.setCenter(mapCenter); 
				map.setZoom(12);
				// mapCenter = map.getCenter();
				// map.setCenter(mapCenter);
    		} else {
        
       			//$('#first-me').fadeIn('slow');
        	$('#map_canvas').fadeOut();
    		}
		});
		
	}
	window.onload = nowRun;

	$(document).on('click', '#submitDirections', function(e) {
		e.preventDefault();
		calculateRoute();
		$("#dirSpecs").hide()
		$("#toDirection").hide()
		$("#fromDirection").hide()
		$("#submitDirections").hide()
		$("#mapOptions").show()
	});
	
	$(document).on('click', '#resetSearch', function(e) {
		window.location.reload();
	});

	var directionDisplay,
		directionsService = new google.maps.DirectionsService(),
		map,
		mapCenter;

	function initialize() 
	{
		directionsDisplay = new google.maps.DirectionsRenderer();
		mapCenter = new google.maps.LatLng(38.9343, -92.3306);

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
	google.maps.event.addDomListener(window, "resize", function() {
    google.maps.event.trigger(map, "resize");
    map.setCenter(mapCenter); 
	});
	}
	
	calculateRoute();
	function calculateRoute() 
	{
		/*
		var x = document.getElementById("map_canvas");
		
		navigator.geolocation.getCurrentPosition(showPosition);
		var latlon;
		
		function showPosition(pos) {
			var latlon = pos.coords.latitude+","+pos.coords.longitude;
			console.log(latlon);
			
		};
		*/
	
	
		var selectedMode = $("#mode").val(),
			start = $("#from").val(),
			end = $("#to").val();

		if(start == '' || end == '')
		{
			// cannot calculate route
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
					/*
						var myRoute = response.routes[0].legs[0];
						for (var i = 0; i < myRoute.steps.length; i++) {
							alert(myRoute.steps[i].instructions);
						}
					*/
				}
				else {
				}
			});

		}
	}