
<link href="<?php echo URL; ?>css/listview_browse.css" rel="stylesheet">
<script src="<?php echo URL; ?>js/listview-browse.js"></script>
  <!--Slider components(Browse page-->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
<script src="<?php echo URL; ?>js/slider-filter.js"></script>
<script src="<?php echo URL; ?>js/distance-slider.js"></script>

<!-- <div class="container" align="center" style="padding-left:400px; top:200px"> 
  <ul class="pagination">
    <li><a href="<?php echo URL; ?>search">1</a></li>
    <li><a href="<?php echo URL; ?>search">2</a></li>
    <li><a href="<?php echo URL; ?>search">3</a></li>
    <li><a href="<?php echo URL; ?>search">4</a></li>
    <li><a href="<?php echo URL; ?>search">5</a></li>
  </ul>
</div> -->

<div class="container">
    <div class="row">
        <h2 align="center">Listings available for rent</h2>
    </div>
    
    <div class="row">
    <div class="col-md-2">
        <p><b>Filter your search results:</b></p>

        <form action="<?php echo URL; ?>search/filterListings" method="get">
            <p>Sort<br>
            <select name="options">
                <option value="recent" <?php if(isset($_GET['options']) && $_GET['options'] == 'recent') echo "selected"; ?>>Most Recent</option>
                <option value="low"  <?php if(isset($_GET['options']) && $_GET['options'] == 'low') echo "selected"; ?>>Price Low to High</option>
                <option value="high" <?php if(isset($_GET['options'])  && $_GET['options'] == 'high') echo "selected"; ?>>Price High to Low</option>
            </select>
            </p>
            <p><label for="amount">Price range:</label>
                <input type="text" id="minr" name="minrange" hidden="true">
                <input type="text" id="maxr" name="maxrange" hidden="true">
                <input type="text" id="amount" readonly style="border:1; font-weight:bold;">
            </p>
            <div id="slider-range"></div>
	    <br>
	    <p><label for="distant">Distance from SFSU:</label>
		<input type="text" id="mind" name="mindistance" hidden="true">
		<input type="text" id="maxd" name="maxdistance" hidden="true">
		<input type="text" id="distant" readonly style="border:1; font-weight:bold;">
	    </p>
	    <div id="distance-range"></div>
	    <br>
 	    <p><input type="checkbox" name="parking" value="1" <?php if(isset($_GET['parking'])) echo "checked='checked'"; ?>>Parking available </p>
	    <p><input type="checkbox" name="accessible" value="1" <?php if(isset($_GET['accessible'])) echo "checked='checked'"; ?>>Accessible </p>
	    <p><input type="checkbox" name="furnished" value="1" <?php if(isset($_GET['furnished'])) echo "checked='checked'"; ?>>Furnished </p>
	    <p><input type="checkbox" name="smoking" value="1" <?php if(isset($_GET['smoking'])) echo "checked='checked'"; ?>>Smoking allowed </p>    
	       <input type="hidden" name="search" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">
            <br><input type="submit" class="btn btn-success" value="Filter results" style="background-color:#33cccc;">
        </form>
    </div>


        <div class="col-md-10">
        <div id="products" class="row list-group">
        <h3 align="left" style="color:#33cccc">Displaying <?php echo sizeof($listings)?> results</h3   >
        
        <?php foreach ($listings as $listing) { ?>
        <div class="item  col-xs-4 col-lg-4 grid-group-item list-group-item">
            <div class="thumbnail col-md-10">
                <div class="div-list-img">
                    <img  class="group list-group-image" src="<?php echo URL . htmlspecialchars($items[$listing->id], ENT_QUOTES, 'UTF-8'); ?>" onerror="if (this.src !='demo-image.png') this.src='<?php echo URL ?>img/demo-image.png';" height="150"/>
                </div>
                <div class="caption">
                    <h4 class="group inner list-group-item-heading">
                        <?php if ($listing->type == 1) echo htmlspecialchars("Apartment", ENT_QUOTES, 'UTF-8');
                          else if ($listing->type == 2) echo htmlspecialchars("House", ENT_QUOTES, 'UTF-8');
                          else if ($listing->type == 3) echo htmlspecialchars("Room", ENT_QUOTES, 'UTF-8'); ?> for rent</h4>
                    <p class="group inner list-group-item-text">
                        <?php if (isset($listing->street)) echo htmlspecialchars($listing->street, ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($listing->city, ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($listing->state, ENT_QUOTES, 'UTF-8'); ?> -
                         <?php echo htmlspecialchars($listing->zipcode, ENT_QUOTES, 'UTF-8'); ?></p>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p class="lead">
                                $<?php if (isset($listing->price)) echo htmlspecialchars($listing->price, ENT_QUOTES, 'UTF-8'); ?> 
                                <small><?php if (isset($listing->size)) echo htmlspecialchars($listing->size, ENT_QUOTES, 'UTF-8'); ?> Sq.ft </small>
                                </p>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <a class="btn btn-success" style="background-color:#33cccc; margin-bottom:5px" href="<?php echo URL . 'search/viewDetail/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>">View More</a>
                        <a class="btn btn-success" style="background-color:#33cccc; margin-bottom:5px" href="<?php echo URL . 'post/contact/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>">Contact Landlord</a> 

                 <!--        <a class="btn btn-success" style="background-color:#33cccc; margin-bottom:5px" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Contact Landlord</a>
                        
                        <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Message</h4>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo URL; ?>post/sendFirstContactMessage" method="POST">
                        <input type="text" name="subject" value="" required /></form>
                        <form>
                            <div class="form-group">
                            <label for="comment">Message:</label>
                            <textarea class="form-control" rows="5" id="comment"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Send</button>
            </div> 
           
           
        </div>
        </div>
        </div> -->
        </div>
        </div>
        </div>
        </div>
            <div class="col-md-2" align="center">
                <?php if (isset($listing->longitude)){ ?>
                <img src="<?php echo 'https://maps.googleapis.com/maps/api/staticmap?center=' . htmlspecialchars($listing->latitude, ENT_QUOTES, 'UTF-8') . ',' . htmlspecialchars($listing->longitude, ENT_QUOTES, 'UTF-8') . '&zoom=13&size=143x152&maptype=roadmap'. '&markers=color:red%7Clabel:%7C' . htmlspecialchars($listing->latitude, ENT_QUOTES, 'UTF-8') . ',' . htmlspecialchars($listing->longitude, ENT_QUOTES, 'UTF-8') . '&key=AIzaSyBq1QDSiyX_pkAjxexQz1HvNudrINhoxxc'; ?>">
                <!--<iframe
                    width="150"
                    height="150"
                    frameborder="0" 
                    style="border:0"
                    src="https://www.google.com/maps/embed/v1/view?key=AIzaSyBfm1QvPnJ7DMzRMzPzqav4_eTvuFgXzkk&center=<?php if (isset($listing->latitude)) echo htmlspecialchars($listing->latitude, ENT_QUOTES, 'UTF-8'); ?>,<?php if (isset($listing->longitude)) echo htmlspecialchars($listing->longitude, ENT_QUOTES, 'UTF-8'); ?>&zoom=14">
                </iframe>-->
                <?php } ?>
            </div>
        </div>
        <?php } ?>
        </div>
        </div>
    <!--
    </div>
</div>
    
    <div class="col-md-3" id="map">
        <script>
            function initMap() {
                var sfsu = {lat: 37.72078, lng: -122.4764};
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 11,
                    center: sfsu
                });
                var marker = new google.maps.Marker({
                    position: sfsu,
                    map: map
                });
            }
            //var infoWindow = new google.maps.InfoWindow;
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACRVvg9BZaGEfupwhboZZfHH1Cx2QWVlk&callback=initMap"></script>
    </div>-->
    </div>
</div>
