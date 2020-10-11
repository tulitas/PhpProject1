<?php
error_reporting(0);
$conn = mysqli_connect("localhost:3307","root","root","php");
if(count($_POST)>0) {
    $roll_no=$_POST[roll_no];
    $result = mysqli_query($conn,"SELECT * FROM rent where town = '$roll_no' || 
                         price = '$roll_no' || 
                         numberOfBathrooms = '$roll_no' || 
                         propertyType = '$roll_no' || 
                         saleRent = '$roll_no'");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title> Retrive data</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <td>County</td>
        <td>Country</td>
        <td>Town</td>
        <td>Price</td>
        <td>Number of bathrooms</td>
        <td>Property type</td>
        <td>Deal</td>


    </tr>
    <?php
    $i=0;
    while($row = mysqli_fetch_array($result)) {
        ?>
        <tr>
            <td><?php echo $row["county"]; ?></td>
            <td><?php echo $row["country"]; ?></td>
            <td><?php echo $row["town"]; ?></td>
            <td><?php echo $row["price"]; ?></td>
            <td><?php echo $row["numberOfBathrooms"]; ?></td>
            <td><?php echo $row["propertyType"]; ?></td>
            <td><?php echo $row["saleRent"]; ?></td>

        </tr>
        <?php
        $i++;
    }
    ?>
</table>
<a href="landingPage.php">landing page</a><br>
</body>
</html>