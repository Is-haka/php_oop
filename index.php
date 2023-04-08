<?php

  require_once "conn.php";

  $db = new DbConnection();
  $conn = $db->getConnection();

  class Userdata {
    private $fName;
    private $age;
    private $email;

    public function __construct($fName, $age, $email) {
      $this->fName = $fName;
      $this->age = $age;
      $this->email = $email;
    }

    public function getFname() {
      return $this->fName;
    }

    public function getAge() {
      return $this->age;
    }
    

    public function getEmail() {
      return $this->email;
    }

  }

  if(isset($_POST["save"])) {

    $udata = new Userdata($_POST["fullname"], $_POST["age"], $_POST["email"]);
    $Fname = $udata->getFname();
    $Email = $udata->getEmail();
    $Age = $udata->getAge();

    $select = $conn->prepare("SELECT * FROM udata WHERE email = ? ");
    $select->bind_param("s", $Email);
    if($select->execute()) {
      $result = $select->get_result();
      if ($result->num_rows <= 0) {
        if($Fname != ""){
          if($Email != "") {
            if($Age != "") {
              $query = $conn->prepare("INSERT INTO udata(`name`, `email`, `age`) VALUES(?, ?, ?)");
              $query->bind_param("ssi", $Fname, $Email, $Age);
              if ($query->execute()) {
                $success = "<span class='badge text-success'>A record saved successfully</span>";
                header("location: ./");
              } else {
                $error = "<span class='badge text-danger'>Error saving a record</span>";
              }
            } else {
              $error = "<span class='badge text-warning'>Age field is required</span>";
            }
          } else {
            $error = "<span class='badge text-warning'>Email field is required</span>";
          }
        } else {
          $error = "<span class='badge text-warning'>Name field is required</span>";
        }

      } else {
        $error = "<span class='badge text-warning'>Data already exists</span>";
      }
    }
  }


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>DATA OOP</title>
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.css">
  </head>
  <body>
    <div class="container">
    <h2 class="m-3 text-center border border-success rounded">DATA</h2>
        <div class="row bg-">
            <div class="formContainer m-4 p-2 col-sm-6 bg-white">
                <form class="form col-sm-6 p-3 border border-info bg-light rounded" action="" method="post">
                  <h3>Input your data here</h3>
                  <div class="py-2">
                    <?php echo (isset($error))? "$error" : ""; ?>
                    <?php echo (isset($success))? "$success" : ""; ?>
                  </div>
                  <div class="name">
                    <input type="text" class="form-control form-control-sm my-1" name="fullname" value="<?php echo (isset($Fname))? "$Fname" : ""; ?>" placeholder="Your full name">
                  </div>
                  <div class="email">
                    <input type="email" class="form-control form-control-sm my-1" name="email" value="<?php echo (isset($Email))? "$Email" : ""; ?>" placeholder="Email address">
                  </div>
                  <div class="age">
                    <input type="text" class="form-control form-control-sm my-1" name="age" value="<?php echo (isset($Age))? "$Age" : ""; ?>" placeholder="Your Age">
                  </div>
                  <div class="save">
                    <input type="submit" class="form-control btn btn-sm btn-primary my-1" name="save" value="save" class="saving">
                  </div>
                </form>
            </div>
              <div class="dataContainer col-sm-5 m-4 p-2 bg-white">
                <div class="tableContainer bg-">
                  <table class="table table-sm table-hover border border-primary">
                    <tr class="bg-dark text-white">
                      <th class="text-center">SN</th>
                      <th class="text-center">Name</th>
                      <th class="text-center">Email</th>
                      <th class="text-center">Age</th>
                      <th class="text-center">Action</th>
                    </tr>
                    <?php
                    $select = $conn->prepare("SELECT * FROM udata");
                    if($select->execute()){
                        $result = $select->get_result();
                        $no = 0;
                        if ($result->num_rows > 0) {
                          while ($rows = $result->fetch_assoc()) {
                            $no++;
                            ?>
                                <tr class="">
                                <td class="bg-dark text-white text-center"><?php echo $no; ?></td>
                                  <td class="text-center"><?php echo $rows['name']; ?></td>
                                  <td class="text-center"><?php echo $rows['email']; ?></td>
                                  <td class="text-center"><?php echo $rows['age']; ?></td>
                                  <td class="bg-light text-center"><?php echo "<a href='./delete.php?id=$rows[id]' class='btn btn-sm btn-danger'>delete</a>"; ?></td>
                                </tr>
                            <?php
                            // $no++;
                          }
                        }
                    } else {
                      echo "Error getting data";
                    }
                    ?>
                  </table>
                </div>
              </div>
        </div>
    </div>

    <script src="./assets/bootstrap/js/bootstrap.js"></script>
  </body>
</html>
