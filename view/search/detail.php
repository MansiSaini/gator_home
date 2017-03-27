<div class="container">
    <!-- fotorama.css & fotorama.js. -->
    <link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
    
    <div class="row" align="center">
        <h2>Details</h2>
    </div>
    <div class="h-divider"></div>
    
    <div>
	<a class="btn btn-success" style="background-color:    #33cccc;"
	 href="javascript:history.go(-1)"onMouseOver="self.status.referrer;return true">
	 Go Back to Listings
	</a>
    </div>

    <div class="row">
        <br><br>
        <div class="col-md-7" align="center">
            <div class="fotorama" data-nav="thumbs" data-width="100%" data-height="400" data-fit="cover" data-allowfullscreen="true">
                <?php foreach ($mediaItems as $mediaItem) { ?>
                    <img src="<?php echo URL . htmlspecialchars($mediaItem->file_path, ENT_QUOTES, 'UTF-8'); ?>">
                <?php } ?>
            </div>
        </div>

        <div class="col-md-5" align="center">
            <a class="btn btn-primary btn-lg btn-block" style="background-color:#33cccc" href="<?php echo URL . 'post/contact/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>">Contact Landlord</a> 

         <!--   <button class="btn btn-primary btn-lg btn-block" style="background-color:#33cccc" data-toggle="modal" data-target="#myModal">Contact Landlord</button> -->

<!--  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">New Message</h4>
        </div>
        <div class="modal-body">
          <h2>New Message</h2>
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
  </div>-->
            <br><br>
            <table>
                <tr>
                    <td>
                        <h4>Price:</h4>
                    </td>
                    <td>
                        <h4>$<?php if (isset($listing->price)) echo htmlspecialchars($listing->price, ENT_QUOTES, 'UTF-8'); ?></h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>Address:</h4>
                    </td>
                    <td>
                        <h4><?php echo htmlspecialchars($listing->apt .", ", ENT_QUOTES, 'UTF-8'); ?><?php if (isset($listing->street)) echo htmlspecialchars($listing->street, ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($listing->city, ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($listing->state, ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($listing->zipcode, ENT_QUOTES, 'UTF-8'); ?></h4>
                    </td>
                </tr>
                <?php if ($listing->cross_street!=NULL) { ?>
                <tr>
                    <td>
                        <h4>Cross Street:</h4>
                    </td>
                    <td>
                        <h4><?php if (isset($listing->cross_street)) echo htmlspecialchars($listing->cross_street, ENT_QUOTES, 'UTF-8'); ?></h4>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td>
                        <h4>Size:</h4>
                    </td>
                    <td>
                        <h4><?php if (isset($listing->size)) echo htmlspecialchars($listing->size, ENT_QUOTES, 'UTF-8'); ?> Sq.ft</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>Bedrooms:</h4>
                    </td>
                    <td>
                        <h4><?php if (isset($listing->bed)) echo htmlspecialchars($listing->bed, ENT_QUOTES, 'UTF-8'); ?></h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>Bathrooms:</h4>
                    </td>
                    <td>
                        <h4><?php if (isset($listing->bath)) echo htmlspecialchars($listing->bath, ENT_QUOTES, 'UTF-8'); ?></h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>SFSU Distance:</h4>
                    </td>
                    <td>
                        <h4><?php if (isset($listing->campus_distance) && $listing->campus_distance >= 0) echo htmlspecialchars(floatval($listing->campus_distance), ENT_QUOTES, 'UTF-8') . ' miles'; else echo 'Unknown' ?></h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>Details:</h4>
                    </td>
                    <td>
                        <h4><?php if (isset($listing->description)) echo htmlspecialchars($listing->description, ENT_QUOTES, 'UTF-8'); ?></h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>Posted on:</h4>
                    </td>
                    <td>
                        <h4><?php if (isset($listing->create_time)) echo htmlspecialchars($listing->create_time, ENT_QUOTES, 'UTF-8'); ?></h4>
                    </td>
                </tr>            
            <!--<h4>Type: <?php if (isset($listing->type)) echo htmlspecialchars($listing->type, ENT_QUOTES, 'UTF-8'); ?></h4>-->
            </table>
        </div>
    </div>
    <div class="h-divider"></div>
      
    <div class="row">
        <div class="col-md-5">
            <br><br><br><br>
            <table>
                <tr>
                    <td>
                        <b>Has parking:</b>
                    </td>
                    <td>
                        <?php if ($listing->has_parking==0){ ?>
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        <?php } else{ ?>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        <?php } ?>
                    </td>  
                </tr>
                <tr>
                    <td>
                        <b>Accessible:</b>
                    </td>
                    <td>
                        <?php if ($listing->is_accessible==0){ ?>
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        <?php } else{ ?>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Is furnished:</b>
                    </td>
                    <td>
                        <?php if ($listing->is_furnished==0){ ?>
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        <?php } else{ ?>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        <?php } ?>
                    </td>  
                </tr>
                <tr>
                    <td>
                        <b>Pets allowed:</b>
                    </td>
                    <td>
                        <?php if ($listing->pets_allowed==0){ ?>
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        <?php } else{ ?>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        <?php } ?>
                    </td>                    
                </tr>
                <tr>
                    <td>
                        <b>Smoking allowed:</b>
                    </td>
                    <td>
                        <?php if ($listing->is_smoke==0){ ?>
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        <?php } else{ ?>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        <?php } ?>
                    </td>                    
                </tr>           
            </table>
        </div>
        
        <div class="col-md-7">
            <br><br>       
            <div class="container" id="dmap">
            <script>
                function initMap() {
                    var home = {lat: <?php if (isset($listing->latitude)) echo htmlspecialchars($listing->latitude, ENT_QUOTES, 'UTF-8'); ?>, lng: <?php if (isset($listing->longitude)) echo htmlspecialchars($listing->longitude, ENT_QUOTES, 'UTF-8'); ?>};
                    var dmap = new google.maps.Map(document.getElementById('dmap'), {
                        zoom: 15,
                        center: home
                    });
                    var marker = new google.maps.Marker({
                        position: home,
                        map: dmap
                    });
                }
                //var infoWindow = new google.maps.InfoWindow;
            </script>
            <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACRVvg9BZaGEfupwhboZZfHH1Cx2QWVlk&callback=initMap">
            </script>
            </div>
        </div>     
    </div>
</div>
