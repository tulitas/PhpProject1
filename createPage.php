<?php
// Include config file
require_once "config.php";
//next line catch sql errors and view it on screen
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// Define variables and initialize with empty values
$county = $country = $town = $description = $displayableaddress = $image = $thumbnail = $latitude = $longitude =
    $numberOfBedrooms = $numberOfBathrooms = $price = $propertyType = $saleRent = "";
$county_err = $country_err = $town_err = $description_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_county = trim($_POST["county"]);
    if (empty($input_county)) {
        $county_err = "Please enter a county.";

    } else {
        $county = $input_county;
    }

    // Validate address
    $input_country = trim($_POST["country"]);
    if (empty($input_country)) {
        $country_err = "Please enter a country.";
    } else {
        $country = $input_country;
    }

    // Validate salary
    $input_town = trim($_POST["town"]);
    if (empty($input_town)) {
        $town_err = "Please enter the town.";
    } else {
        $town = $input_town;
    }
    $input_description = trim($_POST["description"]);
    if (empty($input_description)) {
        $town_err = "Please enter the description.";
    } else {
        $description = $input_description;
    }
    $input_displayableaddress = trim($_POST["displayableaddress"]);
    if (empty($input_displayableaddress)) {
        $town_err = "Please enter the displayableaddress.";
    } else {
        $displayableaddress = $input_displayableaddress;
    }
    $input_image = trim($_POST["image"]);
    if (empty($input_image)) {
        $town_err = "Please enter the image.";
    } else {
        $image = $input_image;
    }
    $input_thumbnail = trim($_POST["thumbnail"]);
    if (empty($input_thumbnail)) {
        $town_err = "Please enter the thumbnail.";
    } else {
        $thumbnail = $input_thumbnail;
    }
    $input_latitude = trim($_POST["latitude"]);
    if (empty($input_latitude)) {
        $town_err = "Please enter the latitude.";
    } else {
        $latitude = $input_latitude;
    }
    $input_longitude = trim($_POST["longitude"]);
    if (empty($input_longitude)) {
        $town_err = "Please enter the longitude.";
    } else {
        $longitude = $input_longitude;
    }
    $input_numberOfBedrooms = trim($_POST["numberOfBedrooms"]);
    if (empty($input_numberOfBedrooms)) {
        $town_err = "Please enter the numberOfBedrooms.";
    } else {
        $numberOfBedrooms = $input_numberOfBedrooms;
    }
    $input_numberOfBathrooms = trim($_POST["numberOfBathrooms"]);
    if (empty($input_numberOfBathrooms)) {
        $town_err = "Please enter the numberOfBathrooms.";
    } else {
        $numberOfBathrooms = $input_numberOfBathrooms;
    }
    $input_price = trim($_POST["price"]);
    if (empty($input_price)) {
        $town_err = "Please enter the price.";
    } else {
        $price = $input_price;
    }
    $input_propertyType = trim($_POST["propertyType"]);
    if (empty($input_propertyType)) {
        $town_err = "Please enter the propertyType.";
    } else {
        $propertyType = $input_propertyType;
    }
    $input_saleRent = trim($_POST["saleRent"]);
    if (empty($input_saleRent)) {
        $town_err = "Please enter the saleRent.";
    } else {
        $saleRent = $input_saleRent;
    }
    // Check input errors before inserting in database
//    if (empty($county_err) && empty($country_err) && empty($town_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO rent (county, country, town, description, 
                                    displayableaddress, image, thumbnail,latitude, 
                                    longitude, numberOfBedrooms, numberOfBathrooms, price,
                                    propertyType, saleRent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssssssss",$param_county,
                $param_country, $param_town, $param_description, $param_displayableaddress,
            $param_image, $param_thumbnail, $param_latitude, $param_longitude, $param_numberOfBedrooms,
                $param_numberOfBathrooms, $param_price, $param_propertyType, $param_saleRent);

            // Set parameters
            $param_county = $county;
            $param_country = $country;
            $param_town = $town;
            $param_description = $description;
            $param_displayableaddress = $displayableaddress;
            $param_image = $image;
            $param_thumbnail = $thumbnail;
            $param_latitude = $latitude;
            $param_longitude = $longitude;
            $param_numberOfBedrooms = $numberOfBedrooms;
            $param_numberOfBathrooms = $numberOfBathrooms;
            $param_price = $price;
            $param_propertyType = $propertyType;
            $param_saleRent = $saleRent;
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
//    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Create Record</h2>
                </div>
                <p>Please fill this form and submit to add employee record to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($county_err)) ? 'has-error' : ''; ?>">
                        <label>County</label>
                        <input type="text" name="county" class="form-control" value="<?php echo $county; ?>">
                        <span class="help-block"><?php echo $county_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                        <label>Country</label>
                        <input type="text" name="country" class="form-control"><?php echo $country; ?></input>
                        <span class="help-block"><?php echo $country_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($town_err)) ? 'has-error' : ''; ?>">
                        <label>Town</label>
                        <input type="text" name="town" class="form-control" value="<?php echo $town; ?>">
                        <span class="help-block"><?php echo $town_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">

                    </div>
                    <div class="form-group <?php echo (!empty($displayableaddress_err)) ? 'has-error' : ''; ?>">
                        <label>Displayable Address</label>
                        <input type="text" name="displayableaddress" class="form-control"
                               value="<?php echo $displayableaddress; ?>">

                    </div>
                    <input type="file" name="image"/>
                    <div class="form-group ">
                        <label>Thumbnail</label>
                        <input type="text" name="thumbnail" class="form-control" value="<?php echo $thumbnail; ?>">

                    </div>
                    <div class="form-group ">
                        <label>Latitude</label>
                        <input type="text" name="latitude" class="form-control" value="<?php echo $latitude; ?>">

                    </div>
                    <div class="form-group ">
                        <label>Longitude</label>
                        <input type="text" name="longitude" class="form-control" value="<?php echo $longitude; ?>">

                    </div>
                    <div class="form-group ">
                        <label>Number Of Bedrooms</label>
                        <input type="text" name="numberOfBedrooms" class="form-control" value="<?php echo $numberOfBedrooms; ?>">

                    </div>
                    <div class="form-group ">
                        <label>Number Of Bathrooms</label>
                        <input type="text" name="numberOfBathrooms" class="form-control" value="<?php echo $numberOfBathrooms; ?>">

                    </div>
                    <div class="form-group ">
                        <label>Price</label>
                        <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">

                    </div>
                    <div class="form-group ">
                        <label>Property Type</label>
                        <input type="text" name="propertyType" class="form-control" value="<?php echo $propertyType; ?>">
                    </div>
                    <div class="form-group ">
                        <label>Deal</label>
                        <select name="saleRent" class="form-control" >
                            <option value="rent">Rent</option>
                            <option value="sale">Sale</option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>