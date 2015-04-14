<!-- Google map script start -->
    <style>
      #map-canvas {
        width: 700px;
        height: 550px;
      }
      button {
        width: 100%;   
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=visualization"></script>
    <script>
        // Adding 500 Data Points
        var map, pointarray, hazemap, denguemap;
        var lat, lng;
		var request_wait;
		
        // Heatmap pointer using lat/long
        var dengueData = [
            //new google.maps.LatLng(1.3510, 103.8550)//,
            // new google.maps.LatLng(1.3510, 103.8250),
            //new google.maps.LatLng(1.3510, 103.8210),
            //new google.maps.LatLng(1.3510, 103.8500)
        ];
        var hazeData = [
            /*new google.maps.LatLng(1.3410, 103.8550),
            new google.maps.LatLng(1.3410, 103.8250),
            new google.maps.LatLng(1.3410, 103.8210),
            new google.maps.LatLng(1.3410, 103.8500)*/
        ];
        
		function addDengueSpot(zip)
		{
			var geocoder = new google.maps.Geocoder();
			var address = String(zip);
			
			geocoder.geocode( {'address': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					lat = results[0].geometry.location.lat();
					lng = results[0].geometry.location.lng();
					 
					//alert("Add to DengueData: " + lat + "," + lng);
					dengueData.push(new google.maps.LatLng(lat, lng)); //Update Dengue Data
					//updateDengueMap(); //Update Dengue Map
					
				} else {
					//alert("Geocode was not successful for the following reason: " + status);
				}
			});
		}
		
		function addHazeSpot(zip)
		{
			var geocoder = new google.maps.Geocoder();
			var address = String(zip);
			
			geocoder.geocode( {'address': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					lat = results[0].geometry.location.lat();
					lng = results[0].geometry.location.lng();
					 
					//alert("Add to HazeData: " + lat + "," + lng);
					hazeData.push(new google.maps.LatLng(lat, lng)); //Update Haze Data
					//updateHazeMap(); //Update Haze Map
					
				} else {
					//alert("Geocode was not successful for the following reason: " + status);	//If the postal code not found, can check here
				}
			});
		}
		
		function updateDengueMap()
		{
			//denguemap.setMap(null);
			var dengueArray = new google.maps.MVCArray(dengueData);
			  denguemap = new google.maps.visualization.HeatmapLayer({
				data: dengueArray
			  });
			//denguemap.setMap(map);
		}
		
		function updateHazeMap()
		{
			//hazemap.setMap(null);
			  var hazeArray = new google.maps.MVCArray(hazeData);
			  hazemap = new google.maps.visualization.HeatmapLayer({
				data: hazeArray
			  });
		  
			//hazemap.setMap(map);
		}
		
		// Initialize map canvas
        function initialize() {
          var mapOptions = {
            zoom: 11,
            center: new google.maps.LatLng(1.3510, 103.8200),
            disableDefaultUI: true,
			draggable: false,
			zoomControl: false,
			keyboardShortcuts: false,
			panControl: false,
			scaleControl: false,
			scrollwheel: false
          };

          map = new google.maps.Map(document.getElementById('map-canvas'),
              mapOptions);

          // Do not touch
          var dengueArray = new google.maps.MVCArray(dengueData);
          var hazeArray = new google.maps.MVCArray(hazeData);

          denguemap = new google.maps.visualization.HeatmapLayer({
            data: dengueArray
          });

          hazemap = new google.maps.visualization.HeatmapLayer({
            data: hazeArray
          });
          // End of DNT

          // Set default view of map to show dengue data
		  //hazemap.setMap(map);
          //denguemap.setMap(map);
        }
        
		/*function updateMap()
		{
			//Load from crisis database (get postal code, pass in, append to the heat map list)
			//Add the list of dengue spots
			addDengueSpot(579837);	//Bishan
			//addDengueSpot(639798);	//NTU
			//addDengueSpot(608549);	//GEM
			
			//Add the list of haze spots
			//addHazeSpot(529510);	//Bedok
			//addHazeSpot(819643);	//Changi
			
			
		}*/
		
        function toggleDengue() {
          hazemap.setMap(null);

          denguemap.setMap(map);
        }

        function toggleHaze() {
          denguemap.setMap(null);

          hazemap.setMap(map);
        }
        
        function changeGradient() {
          var gradient = [
            'rgba(0, 255, 255, 0)',
            'rgba(0, 255, 255, 1)',
            'rgba(0, 191, 255, 1)',
            'rgba(0, 127, 255, 1)',
            'rgba(0, 63, 255, 1)',
            'rgba(0, 0, 255, 1)',
            'rgba(0, 0, 223, 1)',
            'rgba(0, 0, 191, 1)',
            'rgba(0, 0, 159, 1)',
            'rgba(0, 0, 127, 1)',
            'rgba(63, 0, 91, 1)',
            'rgba(127, 0, 63, 1)',
            'rgba(191, 0, 31, 1)',
            'rgba(255, 0, 0, 1)'
          ]
          hazemap.set('gradient', hazemap.get('gradient') ? null : gradient);
          denguemap.set('gradient', denguemap.get('gradient') ? null : gradient);
        }

        function changeRadius() {
          hazemap.set('radius', hazemap.get('radius') ? null : 20);
          denguemap.set('radius', denguemap.get('radius') ? null : 20);
        }

        function changeOpacity() {
          hazemap.set('opacity', hazemap.get('opacity') ? null : 0.2);
          denguemap.set('opacity', denguemap.get('opacity') ? null : 0.2);
        }
		
		google.maps.event.addDomListener(window, 'load', initialize);
    </script>
	
	<?php
	require "connect.php";
	echo '<script>function updateMap(){';
	
	if($result = $db->query("SELECT distinct(postcode) 
											FROM table_event
											WHERE time >= DATE_SUB(SYSDATE(), INTERVAL 30 DAY) and type = 2
											GROUP BY postcode
											HAVING COUNT(postcode) >= 10")) {
		while ($row = $result->fetch_assoc()) {
			$zip = $row['postcode'];
			echo 'addDengueSpot('.$zip.');';
			//echo '\r\n';
		}
	}
	
	if($result = $db->query("SELECT distinct(postcode) 
											FROM table_event
											WHERE time >= DATE_SUB(SYSDATE(), INTERVAL 30 DAY) and type = 3
											GROUP BY postcode
											HAVING COUNT(postcode) >= 10")) {
		while ($row = $result->fetch_assoc()) {
			$zip = $row['postcode'];
			echo 'addHazeSpot('.$zip.');';
			//echo '\r\n';
		}
	}

	echo "updateHazeMap(); updateDengueMap(); hazemap.setMap(null); denguemap.setMap(null);}  google.maps.event.addDomListener(window, 'load', updateMap)";
	echo '</script>';
	?>
    <!-- Google map script end -->