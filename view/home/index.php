<div class="container">
    <?php
        if(isset($_SESSION['is_logged_in']) && isset($_SESSION['first_name'])) {
            $welcome_name = ", " . $_SESSION['first_name'];
        }
        else {
            $welcome_name = " to Gator Home";
        }
    ?>
    <h2>Welcome<?php echo $welcome_name; ?> !</h2>
    <h4>Gator Homes aims at helping SFSU students find the best match for their house rental needs </h4>

<div class="col-lg-12">
    <h3 class="page-header">Recently posted listings</h3> </div>
        <div id="products" class="row list-group">
        <?php $mostRecent = 0; ?>
            <?php foreach ( array_reverse($listings) as $listing) { 
               $mostRecent++;
                 if ($mostRecent > 20)
                    break;
                ?>

        <div class="item  col-xs-4 col-lg-4" style="width:260px;">
            <div class="thumbnail">
                <center>
                    <div class="div-home-img">
                    <img class="group list-group-image" src="<?php echo URL . htmlspecialchars($items[$listing->id], ENT_QUOTES, 'UTF-8'); ?>" onerror="if (this.src !='demo-image.png') this.src='<?php echo URL ?>img/demo-image.png';" alt="" height=170px/>
                    </div>
                </center>
                <div class="caption">
                    <h4 class="group inner list-group-item-heading">
                        <?php if ($listing->type == 1) echo htmlspecialchars("Apartment", ENT_QUOTES, 'UTF-8');
                          else if ($listing->type == 2) echo htmlspecialchars("House", ENT_QUOTES, 'UTF-8');
                          else if ($listing->type == 3) echo htmlspecialchars("Room", ENT_QUOTES, 'UTF-8'); ?> for rent</h4>
                    <div class="div-one-line" width="100%">
                    <p class="group inner list-group-item-text">
                        <?php if(isset($listing->street)) echo htmlspecialchars($listing->street, ENT_QUOTES, 'UTF-8'); ?>,
                    <?php echo htmlspecialchars($listing->city, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p class="lead">
                                $<?php echo htmlspecialchars($listing->price, ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <a class="btn btn-success" style="background-color:#33cccc;"href="<?php echo URL . 'search/viewDetail/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>


