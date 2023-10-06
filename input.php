<?php
// Include file koneksi
include "koneksi.php";

// Proses input data
if (isset($_POST["submit"])) {
    // Ambil data dari form

    $namamasjid = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $qibla = $_POST["qibla"];
    $lin = $_POST["lin"];
    $bj = $_POST["bj"];
    $h = $_POST["h"];
    $tZone = $_POST["tZone"];

    // Query insert data
    $sql = "INSERT INTO datamasjid (nama, alamat, qibla, lin, bj, h, tZone)
            VALUES ('$namamasjid',  '$alamat', '$qibla', '$lin', '$bj', '$h', '$tZone')";

    // Eksekusi query
    $query = $conn->query($sql);

    // Cek hasil query
    if ($query) {
        // Berhasil
        header("Location: output.php");
        exit;
        
    } else {
        // Gagal
        echo "<script>alert('Data gagal diinput!');</script>";
    }
}
?>

<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="iso-8859-1">
    <title>Data Masjid/Musholla/Gedung</title>
    <link rel="shortcut icon" href="masjid.png">
    <meta name="description" content="Data Masjid/Musholla/Gedung & Penentuan Arah Kiblat" />
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    <style> 
    #radius1 {
        border: 1px solid grey;
        padding: 3px;
        border-radius: 8px;
    }
    
    #radius2 {
        border: 2px solid red;
        padding: 10px;
        border-radius: 50px 20px;
    }
    button {
        border-radius: 8px;
    }
    </style>
</head>
<body>
    <div align="center" id='wrap'>
        <h3>DATA MASJID/MUSHOLLA/GEDUNG</h3>
        <div align="center" id='content'>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=Your_API_Key&sensor=false"></script>
        
        <script type="text/javascript">
          var ketinggian;
          var myLatlng = new google.maps.LatLng(-7.00154, 110.42795);
          var map, marker1, marker2;
          var geocoder;
          var _qiblaLat = 21.42252, _qiblaLng = 39.82621, _lineDirKib;
          var mecca = new google.maps.LatLng(_qiblaLat, _qiblaLng);
          var infowindow;
        
          function init() {
            geocoder = new google.maps.Geocoder();
            var myOptions = {
              zoom: 19,
              streetViewControl: true,
              center: myLatlng,
              mapTypeId: google.maps.MapTypeId.SATELLITE,
              heading: 90,
              tilt: 45
            };
        
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
            ketinggian = new google.maps.ElevationService();
            infowindow = new google.maps.InfoWindow({ map: map });
        
            var elevator = new google.maps.ElevationService();
            var trafficLayer = new google.maps.TrafficLayer();
            trafficLayer.setMap(map);
            var script = document.createElement("script");
            script.setAttribute("src", "https://storage.googleapis.com/mapsdevsite/json/quakes.geo.json");
            document.getElementsByTagName("head")[0].appendChild(script);
        
            var transitLayer = new google.maps.TransitLayer();
            transitLayer.setMap(map);
        
            // Add a basic style.
            map.data.setStyle(function (feature) {
              var mag = Math.exp(parseFloat(feature.getProperty("mag"))) * 0.1;
              return {
                icon: {
                  path: google.maps.SymbolPath.CIRCLE,
                  scale: mag,
                  fillColor: "#f00",
                  fillOpacity: 0.35,
                  strokeWeight: 0
                }
              };
            });
        
            _lineDirKib = new google.maps.Polyline({
              strokeColor: "#FF0000",
              strokeOpacity: 1,
              strokeWeight: 2,
              geodesic: true,
              zIndex: 2
            });
        
            _lineDirKib.setMap(map);
        
            marker1 = new google.maps.Marker({
              draggable: true,
              position: myLatlng,
              map: map
            });
        
            google.maps.event.addListener(map, "click", function (event) {
              marker1.setPosition(event.latLng);
              TulisLetak(event.latLng);
            });
        
            google.maps.event.addListener(marker1, "dragend", function () {
              TulisLetak(marker1.getPosition());
            });
        
            map.addListener("click", function (event) {
              displayLocationElevation(event.latLng, elevator);
            });
        
            TulisLetak(myLatlng);
          }
        
          function eqfeed_callback(data) {
            map.data.addGeoJson(data);
          }
        
          function displayLocationElevation(location, elevator) {
            // Initiate the location request
            elevator.getElevationForLocations(
              {
                locations: [location]
              },
              function (results, status) {
                if (status === "OK") {
                  // Retrieve the first result
                  if (results[0]) {
                    // Open the infowindow indicating the elevation at the clicked position.
                    infowindow.setPosition(location);
                    infowindow.setContent("Ketinggian:<br>" + results[0].elevation.toFixed(2) + " m.");
                    infowindow.open(map);
                  } else {
                    infowindow.setContent("No results found");
                  }
                } else {
                  infowindow.setContent("Elevation service failed due to: " + status);
                }
              }
            );
          }
        
          function TulisLetak(x) {
            document.getElementById("lin").value = x.lat().toFixed(5);
            document.getElementById("bj").value = x.lng().toFixed(5);
            document.getElementById("tZone").value = Math.round(x.lng() / 15);
            document.getElementById("qibla").value = kiblat(x.lat(), x.lng()).toFixed(2);
            cariTinggi(x);
            garisKiblat(x);
          }
        
          function cariAlamat() {
            var alamat = document.getElementById("kota").value;
            geocoder.geocode({ address: alamat }, function (results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                marker1.setPosition(results[0].geometry.location);
                TulisLetak(results[0].geometry.location);
              } else {
                alert("Pencarian gagal, sebab: " + status);
              }
            });
          }
        
          function cariTinggi(x) {
            var locations = [];
        
            locations.push(x);
            var positionalRequest = {
              locations: locations
            };
        
            ketinggian.getElevationForLocations(positionalRequest, function (results, status) {
              if (status == google.maps.ElevationStatus.OK) {
                if (results[0]) {
                  document.getElementById("h").value = Math.round(results[0].elevation);
                } else {
                  alert("Ketinggian tidak didapat");
                  document.getElementById("h").value = "0.0";
                }
              } else {
                alert("Gagal mencari ketinggian karena: " + status);
                document.getElementById("h").value = "0.0";
              }
            });
          }
        
          function createCookie(name, value, days) {
            if (days) {
              var date = new Date();
              date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
              var expires = "; expires=" + date.toGMTString();
            } else var expires = "";
            document.cookie = name + "=" + value + expires + "; path=/kiblat";
          }
        
          function saveCookie() {
            var nama = document.getElementById("lin").value;
            nama = nama + "," + document.getElementById("bj").value;
            nama = nama + "," + document.getElementById("h").value;
            nama = nama + "," + document.getElementById("tZone").value;
        
            createCookie("pos", nama, 365);
        
            nama = document.getElementById("kota").value;
            createCookie("Tempat", nama, 365);
        
            alert("Data lokasi telah disimpan!");
          }
        
          function radToDeg(angleRad) {
            return (180.0 * angleRad / Math.PI);
          }
        
          function degToRad(angleDeg) {
            return (Math.PI * angleDeg / 180.0);
          }
        
          function getDirection(lat1, lng1, lat2, lng2) {
            var dLng = lng1 - lng2;
            return radToDeg(getDirectionRad(degToRad(lat1), degToRad(lat2), degToRad(dLng)));
          }
        
          function getDirectionRad(lat1, lat2, dLng) {
            return Math.atan2(Math.sin(dLng), Math.cos(lat1) * Math.tan(lat2) - Math.sin(lat1) * Math.cos(dLng));
          }
        
          function kiblat(lat, lng) {
            var qiblaDir = -getDirection(lat, lng, _qiblaLat, _qiblaLng);
            if (qiblaDir < 0) {
              qiblaDir = qiblaDir + 360;
            }
            return qiblaDir;
          }
        
          function garisKiblat(x) {
            var path = _lineDirKib.getPath();
            if (path.length == 2) {
              path.pop();
              path.push(x);
            } else {
              path.push(mecca);
              path.push(x);
            }
          }
        
          window.onload = function () {
            init();
          };
        </script>
        
        
        <table align="left"  cellspacing="0" cellpadding="1" width="100%" id="radius1">
          <tr align="left" > 
            <td width="150" align="left" >Nama Tempat </td>
            <td><input size="50" type="text" id="kota" placeholder="Nama tempat atau koordinat"/><input type="button" value="Cari" onclick="cariAlamat()"/></td>
         </tr>
        </table>
    </div>    
    <br/><br/><br/>
    <div align="center" id="map_canvas" style="width: 500; height: 400px;"></div>

    <form action="" method="post" enctype="multipart/form-data">
        <table align="left"  cellspacing="0" cellpadding="1" width="100%" id="radius1" style="background-color: white;">
        	<tr>
        		<td  width="150" align="left"  >Nama Tempat</td>
        		<td><input type="text" name="nama"  id="nama" placeholder="Masukkan nama Masjid/Musholla/Gedung" /></td>
        		<td  width="150" align="left" >Alamat Tempat</td>
        		<td><input type="text" name="alamat" id="alamat" placeholder="Masukkan alamat tempat lengkap" oninput="updateGoogleMapsLink()"/></td>
        		
        	</tr>
        	<tr>
        		<td  width="150"  align="left" >Lintang</td>
        		<td><input type="text" name="lin" id="lin" oninput="updateGoogleMapsLink()"/></td>
        		<td  width="150"  align="left" >Bujur</td>
        		<td><input type="text" name="bj" id="bj" oninput="updateGoogleMapsLink()"/></td>        		
        	</tr>  
        
        	<tr>
        		<td  width="150"  align="left" >Arah Kiblat</td>
        		<td><input type="text" name="qibla" id="qibla" /></td>
        		<td  align="left"  width="150" >Ketinggian(m)</td>
        		<td><input type="text" name="h" id="h"></td>
        	</tr>
        	<tr>
        		<td  align="left"  width="150" >Zona waktu </td>
        		<td><input type="text" name="tZone" id="tZone"></td>
        	</tr>
                    
        	<tr>
        		<td align="left"><input type="submit" name="submit" value="Submit" style="background-color: #00FF00; color: black; padding: 10px; height: 40px;"></td>
        	</tr>  
        </table>
    </form>
    <a target="_top" href="output.php"><button style="background-color: #00FF00; color: black; padding: 10px; height: 40px;">Kembali</button></a>
	</body>
</html>
