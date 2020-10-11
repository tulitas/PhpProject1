<?php
// Include config file
require_once "config.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// Define variables and initialize with empty values
$county = $country = $town = $description = $displayableaddress = $image  =
$numberOfBedrooms = $numberOfBathrooms = $price = $propertyType = $saleRent = "";
$name_err = $address_err = $salary_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    $input_county = trim($_POST["county"]);
    if (empty($input_county)) {
        $county_err = "Please enter a county.";

    } else {
        $county = $input_county;
    }
    $input_country = trim($_POST["country"]);
    if (empty($input_country)) {
        $country_err = "Please enter a country.";
    } else {
        $country = $input_country;
    }

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
    if(empty($county_err) && empty($country_err) && empty($town_err)){
        // Prepare an update statement
        $sql = "UPDATE rent SET county=?, country=?, town=?,
                                description=?, displayableaddress=?,
                                 image=?, numberOfBedrooms=?,
                                 numberOfBathrooms=?, price=?,
                                 propertyType=?, saleRent=?, WHERE id=?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssssss",$param_county,
                $param_country, $param_town, $param_description, $param_displayableaddress,
                $param_image, $param_numberOfBedrooms, $param_numberOfBathrooms,
                $param_price, $param_propertyType, $param_saleRent);

            // Set parameters
            $param_county = $county;
            $param_country = $country;
            $param_town = $town;
            $param_description = $description;
            $param_displayableaddress = $displayableaddress;
            $param_image = $image;
            $param_numberOfBedrooms = $numberOfBedrooms;
            $param_numberOfBathrooms = $numberOfBathrooms;
            $param_price = $price;
            $param_propertyType = $propertyType;
            $param_saleRent = $saleRent;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

    }
    // Close connection
    mysqli_close($link);

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM rent WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $county = $row["county"];
                    $country = $row["country"];
                    $town = $row["town"];
                    $description = $row["description"];
                    $displayableaddress = $row["displayableaddress"];
                    $image = $row["image"];
                    $numberOfBedrooms = $row["numberOfBedrooms"];
                    $numberOfBathrooms = $row["numberOfBathrooms"];
                    $price = $row["price"];
                    $propertyType = $row["propertyType"];
                    $saleRent = $row["saleRent"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
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
                    <h2>Update Record</h2>
                </div>
                <p>Please edit the input values and submit to update the record.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label>County</label>
                        <input type="text" name="county" class="form-control" value="<?php echo $county; ?>">
                    </div>
                    <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                        <label>Country</label>
                        <textarea name="country" class="form-control"><?php echo $country; ?></textarea>
                    </div>
                    <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                        <label>Town</label>
                        <input type="text" name="town" class="form-control" value="<?php echo $town; ?>">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">
                    </div>
                    <div class="form-group">
                        <label>Displayable address</label>
                        <input type="text" name="displayableaddress" class="form-control" value="<?php echo $displayableaddress; ?>">
                    </div>

                    <input type="file" name="image" class="form-control" value="<?php echo $image; ?>"/>
                    <div class="form-group">
                        <label>Number Of Bedrooms</label>
                        <input type="text" name="numberOfBedrooms" class="form-control" value="<?php echo $numberOfBedrooms; ?>">
                    </div>
                    <div class="form-group">
                        <label>Number Of Bathrooms</label>
                        <input type="text" name="numberOfBathrooms" class="form-control" value="<?php echo $numberOfBathrooms; ?>">
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                    </div>
                    <div class="form-group">
                        <label>Property Type</label>
                        <input type="text" name="propertyType" class="form-control" value="<?php echo $propertyType; ?>">
                    </div>
                    <div class="form-group">
                        <label>Deal</label>
                        <input type="text" name="saleRent" class="form-control" value="<?php echo $saleRent; ?>">
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<a href="index.php">home</a>

</body>
</html>