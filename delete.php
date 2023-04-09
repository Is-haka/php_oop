<?php

    require_once "conn.php";

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $db = new DbConnection;
        $conn = $db->getConnection();

        $id = $_GET['id'];
        $delete = $conn->prepare("DELETE FROM udata WHERE id = ? ");
        $delete->bind_param("i", $id);

        if ($delete->execute()) {
            $deleted = "<span class='alert alert-success text-success text-center mess is-valid'>Record deleted successfully</span>";
            header("refresh:1; ./index.php");
        } else {
            $error = "<span class='alert alert-danger text-danger text-center mess is-invalid'>Error deleting a record</span>";
            header("refresh:1; ./index.php");
        }

        $db->closeConnection();
    } else {
        $error = "<span class='alert alert-danger text-danger text-center mess is-invalid'>Unable to get the ID</span>";
        header("refresh:1; ./index.php");
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="./assets/others/style.css">
</head>
<body>
        
        <div class="container">
            <div class="row col-sm-15 middle">
                <?php echo (isset($deleted))? $deleted : ""; ?>
                <?php echo (isset($error))? $error : ""; ?>
            </div>
        </div>

<script src="./assets/bootstrap/js/bootstrap.js"></script>
</body>
</html>