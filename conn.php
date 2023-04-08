<?php

  class DbConnection {
    private $host = "localhost";
    private $name = "data";
    private $user = "root";
    private $pass = "";
    private $con;


    public function __construct() {
      $this->con = mysqli_connect($this->host, $this->user, $this->pass, $this->name) or die("Connection failed" . mysqli_connect_error());
    }

    public function getConnection() {
      return $this->con;
    }

    public function setCon($con){
      $this->con = $con;
    }

    public function closeConnection() {
      mysqli_close($this->con);
    }

  }

  $dbConnect = new DbConnection();
  $dbConnect->getConnection();
 ?>
