<div class='container'>
<h2 align="center">Create a new listing</h2>
<h5 align="center" style="color:red;">All fields marked with * are required</h5>
<div class='col-sm-2'>
</div>
<div class='col-sm-8'>
<div class="form-listing">
    <form name="newlisting" id="newlisting" action="<?php echo URL; ?>post/add" method="POST" enctype="multipart/form-data">
    <div class="form-group">
            <div>

            <label>Type of Listing: </label>
            <select class="form-control" name="type">
                <option value="1">Apartment</option>
                <option value="2">House</option>
                <option value="3">Room</option>
            </select>
            </div>
            <div>
            <label for='street'>Street: *</label>
            <input class="form-control" type="text" name="street" id="street" value="" required />
            </div>
            
            <!-- Print the cross street only if it is present -->
            <div>
            <label for='cross_street'>Cross Street:</label>
            <input class="form-control" type="text" name="cross_street" id="cross_street" value="" />
            </div>

            <div>
            <label for='apt'>Apt:</label>
            <input class="form-control" type="text" name="apt" id="apt" value="" />
            </div>

            <div>
            <label for='city'>City: *</label>
            <input class="form-control" type="text" name="city" id="city" value="" required />
            </div>

            <div>
            <label for='state'>State: *</label>
            <select class='form-control' name='state' id='state' class='required'>
                <option value="">Select a State</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            </select><br>
            </div>

            <div>
            <label for='zipcode'>Zipcode: *</label>
            <input class="form-control"  type="text" name="zipcode" id="zipcode" value="" required />
            </div>
            
            <div>
            <label for='bed'>Bedrooms: *</label>
            <select class="form-control" name="bed" id="bed" required>
                <option value="0">0</option>
                <option value="1" selected>1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
            </div>

            <div>
            <label for='bath'>Bathrooms: *</label>
            <select class="form-control" name="bath" id="bath" required>
                <option value="0">0</option>
                <option value="1" selected>1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
            </div>

            <div>
            <label for='size'>Size: *<small> (in Sq. ft) </small></label>
            <input class="form-control" type="text" name="size" id="size" value="" required />
            </div>

            <div>
            <label for='price'>Price: *<small> (in $) </small></label>
            <input class='form-control' type="text" name="price" id="price" value="" required />
            </div>
            
            <div>
            <label for='description'>Description: *</label>
            <textarea class="form-control" rows=5 name="description" value="" placeholder="Please specify other details, including the days and time for open-house" required ></textarea>
            </div>

            <br>
            <label for='has_parking'>Other Amenities:</label>
            <div class='checkbox'>
            <label><input type="checkbox" name="has_parking" value="1" />Has Parking</label>
            </div>
            <div class='checkbox'>
            <label><input type="checkbox" name="is_accessible" value="1" />Accessible</label>
            </div>
            <div class='checkbox'>
            <label><input type="checkbox" name="is_furnished" value="1" />Furnished</label>
            </div>
            <div class='checkbox'>
            <label><input type="checkbox" name="pets_allowed" value="1" />Pets allowed</label>
            </div>
            <div class='checkbox'>
            <label><input type="checkbox" name="is_smoke" value="1" />Smoking allowed</label>
            </div>
            <br>
            <div>
                <label>Upload Photo(s): </label>
                <small> (Supported Image Formats: .jpeg, .jpg, .png) </small> 
                    <input class="form-control" type="file" name="files[]" multiple />
            </div>
            <br>

            <div class='checkbox'>
            <label><input type="checkbox" name="privacybox" required/>I agree to the privacy policy as given <a href="<?php echo URL ?>support/privacy" target="_blank"> here </a>.</label>
            </div>
            <div align="center">
            <input class="btn btn-primary" style="background-color:#33cccc;" type="submit" name="submit_add_post" value="Create" />
            </div>
            </div>
    </form>
    </div>
</div>
</div>
<script>
    $.validator.addMethod("lettersSpace", function(value, element) 
    {
         return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
    });

    $(document).ready(function()
    {
        $('#newlisting').validate(
        {
            rules:
            {
                street:
                {
                    required: true
                },

                city:
                {
                    required: true,
                    lettersSpace: true
                },

                apt:
                {
                    required: function(element)
                                {
                                    return $("#cross_street").val().length < 1;
                                }
                },

                state:
                {
                    required: true
                },

                zipcode:
                {
                    required: true,
                    digits: true,
                    minlength: 5,
                    maxlength: 5
                },

                size:
                {
                    required: true,
                    digits: true
                },

                price:
                {
                    required: true,
                    number: true
                },

                description:
                {
                    required: true
                },

                privacybox:
                {
                    required: true
                },
            },

            messages:
            {
                street:
                {
                    required: "Street name is required!"
                },

                apt:
                {
                    required: "Please provide an apartment number or cross street!"
                },

                city:
                {
                    required: "City name is required!",
                    lettersSpace: "No numbers or special characters!"
                },

                state:
                {
                    required: "Please select a state!"
                },

                zipcode:
                {
                    required: "Zipcode is required!",
                    digits: "No letters or special characters!"
                },

                size:
                {
                    required: "Listing's size is required!",
                    digits: "No letters or special characters!"
                },

                price:
                {
                    required: "Price is required!",
                    number: "No letters or special characters!"
                },

                description:
                {
                    required: "Please make a description!"
                },

                privacybox:
                {
                    required: "Please agree to the privacy policy before posting."
                },
            },

            errorPlacement: function (error, element)
            {
                error.insertAfter(element);
                error.css('color', '#ff0000');
            },

            submitHandler: function (form)
            {
                form.submit();
            },
        });
    });
</script>
