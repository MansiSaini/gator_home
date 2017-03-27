
<link href="<?php echo URL; ?>css/listview_browse.css" rel="stylesheet">
<script src="<?php echo URL; ?>js/listview-browse.js"></script>

    <?php
        $loginUrl = URL . "login";
        if(isset($_SESSION['is_logged_in']) && isset($_SESSION['first_name'])) {
            $message = "Your listings";
            $is_authorized = 1;
        }
        else {
            $message = "Please <a href=" . $loginUrl . ">login</a> to Post or view your listings.";
            $is_authorized = 0;
        }
    ?>

    <h2 align="center"><?php echo $message; ?></h2>
    <?php
        if(isset($_SESSION['is_logged_in']) && isset($_SESSION['first_name'])) { ?>
    
     <div class="container">
     <form action="<?php echo URL; ?>post/create" method="post">
     <button type="submit" name ='submit_add_post' value="Create a New Listing" class="btn btn-success" style="position:relative; background-color: #33cccc">Create New Listing</button>

    <div class="col-sm-6" style="margin-left:25%">
        <div id="products" class="row list-group">
        <h4 align="left" style="color:#33cccc">Displaying <?php echo sizeof($listings)?> results</h4>
        <?php foreach ($listings as $listing) { ?>
        <div class="item  col-xs-4 col-lg-4 grid-group-item list-group-item">
            <div class="thumbnail">
                <img class="group list-group-image" src="<?php echo URL . htmlspecialchars($items[$listing->id], ENT_QUOTES, 'UTF-8'); ?>" onerror="if (this.src !='demo-image.png') this.src='<?php echo URL ?>img/demo-image.png';" height="150" width="150"/>
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
                        <!--URLS FOR THESE BUTTONS NEED TO BE CHANGED -->
                        <div class="col-xs-12 col-md-6">
                            <a class="btn btn-success" style="background-color:#33cccc; margin-bottom:5px" href="<?php echo URL . 'search/viewDetail/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>">View</a>
                            <a class="btn btn-success" style="background-color:#33cccc; margin-bottom:5px" href="<?php echo URL . 'post/edit/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>">Edit</a>
                            <a class="btn btn-success" style="background-color:#33cccc; margin-bottom:5px" href="<?php echo URL . 'post/delete/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
</div>

    <!--
    <?php foreach ($listings as $listing) { ?>
                <tr>
                    <td><?php if (isset($listing->id)) echo htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($listing->price)) echo htmlspecialchars($listing->price, ENT_QUOTES, 'UTF-8'); ?> $</td>
                    <td><?php if (isset($listing->type)) echo htmlspecialchars($listing->type, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($listing->street)) echo htmlspecialchars($listing->street, ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($listing->city, ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($listing->state, ENT_QUOTES, 'UTF-8'); ?> -
                         <?php echo htmlspecialchars($listing->zipcode, ENT_QUOTES, 'UTF-8'); ?>
                    </td>
                    <td><?php if (isset($listing->size)) echo htmlspecialchars($listing->size, ENT_QUOTES, 'UTF-8'); ?> Sq.ft</td>
                    <td><?php if (isset($listing->create_time)) echo htmlspecialchars($listing->create_time, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($listing->description)) echo htmlspecialchars($listing->description, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><button type="button" onclick="window.location.href='<?php echo URL . 'browse/viewDetail/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>'">View</button></td>
                    <td><button type="button" onclick="window.location.href='<?php echo URL . 'post/delete/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>'">Delete</button></td>
                    <td><button type="button" onclick="window.location.href='<?php echo URL . 'post/edit/' . htmlspecialchars($listing->id, ENT_QUOTES, 'UTF-8'); ?>'">Edit</button></td>                               
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div> <?php } ?> 
    -->
</div>
