<?php

$page_id = get_the_id();

?>

<?php
// NYC
if ( $page_id == 79){
    ?>
    <div class="container-outer-wrap lt-gray-bg">
        <div class="container location__map-outer-wrap">
            <div class="location__map-wrap">
                <div class="location__g-map-outer-wrap" onClick="style.pointerEvents='none'">
                    <div id="gmap"></div>
                </div>
                <div class="location__address-wrap">
                    <h5 class="red">A-LIST NEW YORK</h5>
                    <p>A-List Education <br>
                    29 W 36 th Street, 7th Fl.<br>
                    New York, NY 10018 <br>
                    <strong>Telephone:</strong> <a href="tel:16462169187">646-216-9187</a></p>
                    <p>Monday-Friday, 9:30AM-6:00PM</p>
                </div>
            </div>
            <div class="location__map-meta-wrap">
                <div class="location__map-meta-inner-wrap">
                    <h5 class="red">GENERAL INQUIRIES</h5>
                    <p><strong>Telephone:</strong> <a href="tel:16462169187">646.216.9187</a> (NYC Office) <br>
                    <strong>Fax:</strong> 212.661.0487 <br>
                    <strong>Email:</strong> <a href="mailto:info@alisteducation.com">info@alisteducation.com</a></p>
                    <h5 class="red">SUPPORT</h5>
                    <p>Currently working with us and have questions? <br>
                    We’re happy to help! <br>
                    Please email <a href="mailto:support@alisteducation.com">support@alisteducation.com</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
      function initMap() {
        var nyc = {lat: 40.7505808, lng: -73.9873436};
        var map = new google.maps.Map(document.getElementById('gmap'), {
          zoom: 15,
          center: nyc
        });
        map.set('scrollwheel', false);
        var marker = new google.maps.Marker({
          position: nyc,
          map: map
        });
      }
    </script>
    <?php
} 
?>

<?php

// LA
if ( $page_id == 435){
    ?>
    <div class="container-outer-wrap lt-gray-bg">
        <div class="container location__map-outer-wrap">
            <div class="location__map-wrap">
                <div class="location__g-map-outer-wrap" onClick="style.pointerEvents='none'">
                    <div id="gmap"></div>
                </div>
                <div class="location__address-wrap">
                    <h5 class="red">A-LIST LOS ANGELES</h5>
                    <p>A-List Education <br>
                    5250 Lankershim Blvd, 5th floor, #536 <br>
                    North Hollywood, CA 91601 <br>
                    <strong>Telephone:</strong> <a href="tel:18183054728">818-305-4728</a><br>
                    <strong>Email:</strong> <a href="mailto:alist.la@alisteducation.com">alist.la@alisteducation.com</a></p>
                    <p>Monday-Friday, 9:30AM-6:00PM</p>
                </div>
            </div>
            <div class="location__map-meta-wrap">
                <div class="location__map-meta-inner-wrap">
                    <h5 class="red">GENERAL INQUIRIES</h5>
                    <p><strong>Telephone:</strong> <a href="tel:16462169187">646.216.9187</a> (NYC Office) <br>
                    <strong>Fax:</strong> 212.661.0487 <br>
                    <strong>Email:</strong> <a href="mailto:info@alisteducation.com">info@alisteducation.com</a></p>
                    <h5 class="red">SUPPORT</h5>
                    <p>Currently working with us and have questions? <br>
                    We’re happy to help! <br>
                    Please email <a href="mailto:support@alisteducation.com">support@alisteducation.com</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
      function initMap() {
        var nyc = {lat: 40.7127837, lng: -74.00594130000002};
        var map = new google.maps.Map(document.getElementById('gmap'), {
          zoom: 15,
          center: nyc
        });
        map.set('scrollwheel', false);
        var marker = new google.maps.Marker({
          position: nyc,
          map: map
        });
      }
    </script>
    <?php
} 

?>

<?php

// Boston
if ( $page_id == 440){
    ?>
    <div class="container-outer-wrap lt-gray-bg">
        <div class="container location__map-outer-wrap">
            <div class="location__map-wrap">
                <div class="location__g-map-outer-wrap" onClick="style.pointerEvents='none'">
                    <div id="gmap"></div>
                </div>
                <div class="location__address-wrap">
                    <h5>A-LIST BOSTON</h5>
                    <p>A-List Education <br>
                    <strong>Telephone:</strong> <a href="tel:17185199599">718-519-9599</a><br>
                    <strong>Email:</strong> <a href="mailto:alist.boston@alisteducation.com">alist.boston@alisteducation.com</a></p>
                    <p>Monday-Friday, 9:30AM-6:00PM</p>
                </div>
            </div>
            <div class="location__map-meta-wrap">
                <div class="location__map-meta-inner-wrap">
                    <h5>GENERAL INQUIRIES</h5>
                    <p><strong>Telephone:</strong> <a href="tel:16462169187">646.216.9187</a> (NYC Office) <br>
                    <strong>Fax:</strong> 212.661.0487 <br>
                    <strong>Email:</strong> <a href="mailto:info@alisteducation.com">info@alisteducation.com</a></p>
                    <h5>SUPPORT</h5>
                    <p>Currently working with us and have questions? <br>
                    We’re happy to help! <br>
                    Please email <a href="mailto:support@alisteducation.com">support@alisteducation.com</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
      function initMap() {
        var nyc = {lat: 42.3600825, lng: -71.05888010000001};
        var map = new google.maps.Map(document.getElementById('gmap'), {
          zoom: 15,
          center: nyc
        });
        map.set('scrollwheel', false);
        var marker = new google.maps.Marker({
          position: nyc,
          map: map
        });
      }
    </script>
    <?php
} 

?>

<?php

// New Jersey
if ( $page_id == 2088){
    ?>
    <div class="container-outer-wrap lt-gray-bg">
        <div class="container location__map-outer-wrap">
            <div class="location__map-wrap">
                <div class="location__g-map-outer-wrap" onClick="style.pointerEvents='none'">
                    <div id="gmap"></div>
                </div>
                <div class="location__address-wrap">
                    <h5 class="red">A-LIST NEW JERSEY</h5>
                    <p>A-List Education <br>
                    29 W 36 th Street, 7th Fl.<br>
                    New York, NY 10018 <br>
                    <strong>Telephone:</strong> <a href="tel:16462169187">646-216-9187</a></p>
                    <p>Monday-Friday, 9:30AM-6:00PM</p>
                </div>
            </div>
            <div class="location__map-meta-wrap">
                <div class="location__map-meta-inner-wrap">
                    <h5 class="red">GENERAL INQUIRIES</h5>
                    <p><strong>Telephone:</strong> <a href="tel:16462169187">646.216.9187</a> (NYC Office) <br>
                    <strong>Fax:</strong> 212.661.0487 <br>
                    <strong>Email:</strong> <a href="mailto:info@alisteducation.com">info@alisteducation.com</a></p>
                    <h5 class="red">SUPPORT</h5>
                    <p>Currently working with us and have questions? <br>
                    We’re happy to help! <br>
                    Please email <a href="mailto:support@alisteducation.com">support@alisteducation.com</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
      function initMap() {
        var nyc = {lat: 40.7505808, lng: -73.9873436};
        var map = new google.maps.Map(document.getElementById('gmap'), {
          zoom: 15,
          center: nyc
        });
        map.set('scrollwheel', false);
        var marker = new google.maps.Marker({
          position: nyc,
          map: map
        });
      }
    </script>
    <?php
} 

?>

<?php

// Connecticut
if ( $page_id == 2097){
    ?>
    <div class="container-outer-wrap lt-gray-bg">
        <div class="container location__map-outer-wrap">
            <div class="location__map-wrap">
                <div class="location__g-map-outer-wrap" onClick="style.pointerEvents='none'">
                    <div id="gmap"></div>
                </div>
                <div class="location__address-wrap">
                    <h5 class="red">A-LIST NEW CONNECTICUT</h5>
                    <p>A-List Education <br>
                    29 W 36 th Street, 7th Fl.<br>
                    New York, NY 10018 <br>
                    <strong>Telephone:</strong> <a href="tel:16462169187">646-216-9187</a></p>
                    <p>Monday-Friday, 9:30AM-6:00PM</p>
                </div>
            </div>
            <div class="location__map-meta-wrap">
                <div class="location__map-meta-inner-wrap">
                    <h5 class="red">GENERAL INQUIRIES</h5>
                    <p><strong>Telephone:</strong> <a href="tel:16462169187">646.216.9187</a> (NYC Office) <br>
                    <strong>Fax:</strong> 212.661.0487 <br>
                    <strong>Email:</strong> <a href="mailto:info@alisteducation.com">info@alisteducation.com</a></p>
                    <h5 class="red">SUPPORT</h5>
                    <p>Currently working with us and have questions? <br>
                    We’re happy to help! <br>
                    Please email <a href="mailto:support@alisteducation.com">support@alisteducation.com</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
      function initMap() {
        var nyc = {lat: 40.7505808, lng: -73.9873436};
        var map = new google.maps.Map(document.getElementById('gmap'), {
          zoom: 15,
          center: nyc
        });
        map.set('scrollwheel', false);
        var marker = new google.maps.Marker({
          position: nyc,
          map: map
        });
      }
    </script>
    <?php
} 

?>

<?php

// Westchester
if ( $page_id == 2094){
    ?>
    <div class="container-outer-wrap lt-gray-bg">
        <div class="container location__map-outer-wrap">
            <div class="location__map-wrap">
                <div class="location__g-map-outer-wrap" onClick="style.pointerEvents='none'">
                    <div id="gmap"></div>
                </div>
                <div class="location__address-wrap">
                    <h5 class="red">A-LIST NEW WESTCHESTER</h5>
                    <p>A-List Education <br>
                    29 W 36 th Street, 7th Fl.<br>
                    New York, NY 10018 <br>
                    <strong>Telephone:</strong> <a href="tel:16462169187">646-216-9187</a></p>
                    <p>Monday-Friday, 9:30AM-6:00PM</p>
                </div>
            </div>
            <div class="location__map-meta-wrap">
                <div class="location__map-meta-inner-wrap">
                    <h5 class="red">GENERAL INQUIRIES</h5>
                    <p><strong>Telephone:</strong> <a href="tel:16462169187">646.216.9187</a> (NYC Office) <br>
                    <strong>Fax:</strong> 212.661.0487 <br>
                    <strong>Email:</strong> <a href="mailto:info@alisteducation.com">info@alisteducation.com</a></p>
                    <h5 class="red">SUPPORT</h5>
                    <p>Currently working with us and have questions? <br>
                    We’re happy to help! <br>
                    Please email <a href="mailto:support@alisteducation.com">support@alisteducation.com</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
      function initMap() {
        var nyc = {lat: 40.7505808, lng: -73.9873436};
        var map = new google.maps.Map(document.getElementById('gmap'), {
          zoom: 15,
          center: nyc
        });
        map.set('scrollwheel', false);
        var marker = new google.maps.Marker({
          position: nyc,
          map: map
        });
      }
    </script>
    <?php
} 

?>

<?php

// Long Island
if ( $page_id == 2091){
    ?>
    <div class="container-outer-wrap lt-gray-bg">
        <div class="container location__map-outer-wrap">
            <div class="location__map-wrap">
                <div class="location__g-map-outer-wrap" onClick="style.pointerEvents='none'">
                    <div id="gmap"></div>
                </div>
                <div class="location__address-wrap">
                    <h5 class="red">A-LIST LONG ISLAND</h5>
                    <p>A-List Education <br>
                    29 W 36 th Street, 7th Fl.<br>
                    New York, NY 10018 <br>
                    <strong>Telephone:</strong> <a href="tel:16462169187">646-216-9187</a></p>
                    <p>Monday-Friday, 9:30AM-6:00PM</p>
                </div>
            </div>
            <div class="location__map-meta-wrap">
                <div class="location__map-meta-inner-wrap">
                    <h5 class="red">GENERAL INQUIRIES</h5>
                    <p><strong>Telephone:</strong> <a href="tel:16462169187">646.216.9187</a> (NYC Office) <br>
                    <strong>Fax:</strong> 212.661.0487 <br>
                    <strong>Email:</strong> <a href="mailto:info@alisteducation.com">info@alisteducation.com</a></p>
                    <h5 class="red">SUPPORT</h5>
                    <p>Currently working with us and have questions? <br>
                    We’re happy to help! <br>
                    Please email <a href="mailto:support@alisteducation.com">support@alisteducation.com</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
      function initMap() {
        var nyc = {lat: 40.789142, lng: -73.13496099999998};
        var map = new google.maps.Map(document.getElementById('gmap'), {
          zoom: 15,
          center: nyc
        });
        map.set('scrollwheel', false);
        var marker = new google.maps.Marker({
          position: nyc,
          map: map
        });
      }
    </script>
    <?php
} 

?>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaaYForIm--xMOE1km2ebketRwZLiiCwQ&callback=initMap">
</script>
