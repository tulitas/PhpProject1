<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$county = $country = $town = $description = $displayableaddress = $thumbnail = "";
$county_err = $country_err = $town_err = $description_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_county = trim($_POST["county"]);
    if(empty($input_county)){
        $county_err = "Please enter a county.";

    } else{
        $county = $input_county;
    }

    // Validate address
    $input_country = trim($_POST["country"]);
    if(empty($input_country)){
        $country_err = "Please enter a country.";
    } else{
        $country = $input_country;
    }

    // Validate salary
    $input_town = trim($_POST["town"]);
    if(empty($input_town)){
        $town_err = "Please enter the town.";
    }  else{
        $town = $input_town;
    }

    // Check input errors before inserting in database
    if(empty($county_err) && empty($country_err) && empty($town_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO rent (count, country, town, description, displayableaddress, image, thumbnail
) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss",
                $param_county,
                $param_country,
                $param_town);

            // Set parameters
            $param_county = $county;
            $param_country = $country;
            $param_town = $town;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2>Create Record</h2>
                </div>
                <p>Please fill this form and submit to add employee record to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($county_err)) ? 'has-error' : ''; ?>">
                        <label>County</label>
                        <input type="text" name="county" class="form-control" value="<?php echo $county; ?>">
                        <span class="help-block"><?php echo $county_err;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                        <label>Country</label>
                        <input type="text" name="country" class="form-control"><?php echo $country; ?></input>
                        <span class="help-block"><?php echo $country_err;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($town_err)) ? 'has-error' : ''; ?>">
                        <label>Town</label>
                        <input type="text" name="town" class="form-control" value="<?php echo $town; ?>">
                        <span class="help-block"><?php echo $town_err;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">

                    </div>
                    <div class="form-group <?php echo (!empty($displayableaddress_err)) ? 'has-error' : ''; ?>">
                        <label>Displayable Address</label>
                        <input type="text" name="displayableaddress" class="form-control" value="<?php echo $displayableaddress; ?>">

                    </div>
                    <input type="file" name="image" />
                    <div class="form-group ">
                        <label>Thumbnail</label>
                        <input type="text" name="thumbnail" class="form-control" value="<?php echo $thumbnail; ?>">

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