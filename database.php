<?php

class Db
{
    // The database connection
    protected static $connection;

    // Connect using config.ini
    public function connect()
    {
        if (!isset(self::$connection)) {
            $configPath = __DIR__ . "/config.ini";
            if (!file_exists($configPath)) {
                die("Missing config.ini file.");
            }

            $config = parse_ini_file($configPath, true);
            if (!isset($config['database'])) {
                die("Missing [database] section in config.ini.");
            }

            self::$connection = new mysqli(
                $config['database']['server'],
                $config['database']['username'],
                $config['database']['password'],
                $config['database']['dbname']
            );

            if (self::$connection->connect_error) {
                die("Connection failed: " . self::$connection->connect_error);
            }
        }

        return self::$connection;
    }

    // Query the database
    public function query($query)
    {
        $connection = $this->connect();
        return $connection->query($query);
    }

    public function select($query)
    {
        $rows = [];
        $result = $this->query($query);
        if ($result === false) return false;
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function error()
    {
        $connection = $this->connect();
        return $connection->error;
    }

    /**
     * Quote and escape value for use in a database query
     *
     * @param string $value The value to be quoted and escaped
     * @return string The quoted and escaped string
     */
    public function quote($value)
    {
        $connection = $this->connect();
        return "'" . $connection->real_escape_string($value) . "'";
    }






    ///////////////////// Function to insert a new house booking
        
    public function housebook($conn, $bookphone, $bookname, $bookemail, $bookcategory, $bookdate, $booksubject, $bookmessage, $carImgUpPath)
    {
        $sql = "INSERT INTO tbl_housebooks (name, email, category_fk, path, date, phone, subject, message) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisssss", $bookname, $bookemail, $bookcategory, $carImgUpPath, $bookdate, $bookphone, $booksubject, $bookmessage);
        return $stmt->execute();
    }

    public function catetypeDd($conn)
    {
        $query = "SELECT Id, description FROM tbl_categ";
        return $conn->query($query);
    }

    // Function to update an existing house booking
    function updateHouseBook($conn, $houseID, $bookname, $bookemail, $bookphone, $bookcategory, $bookdate, $booksubject, $bookmessage)
    {
        $sql = "UPDATE tbl_housebooks 
                SET name=?, email=?, phone=?, category_fk=?, date=?, subject=?, message=? 
                WHERE houseID=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $bookname, $bookemail, $bookphone, $bookcategory, $bookdate, $booksubject, $bookmessage, $houseID);
        
        return $stmt->execute();
    }

    // Function to delete a house booking by ID
    function delhouByID($conn, $houseID)
    {
        $sql = "DELETE FROM tbl_housebooks WHERE houseID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $houseID);
        
        return $stmt->execute();
    }

    // Function to fetch all house listings
    function showCars($conn)
    {
        $query = "SELECT houseID, name AS bookname, email AS bookemail, phone AS bookphone, category_fk AS bookcategory, 
                        date AS bookdate, subject AS booksubject, message AS bookmessage, path 
                FROM tbl_housebooks";

        return mysqli_query($conn, $query);
    }

    // Function to fetch a single house listing by ID
    function getHouseByID($conn, $houseID)
    {
        $query = "SELECT * FROM tbl_housebooks WHERE houseID=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $houseID);
        $stmt->execute();
        return $stmt->get_result();
    }

   ///////////////////////////////////////////////////////////








   function inserUser($conn, $bookemail, $hashedpassword, $facepath, $bookname, $booksurname, $booknumber, $bookgender)
   {
       
       $sql = "INSERT INTO `tbl_users` (`email`, `password`, `facepath`, `name`, `surname`, `number`, `gender_fk`) VALUES ('$bookemail', '$hashedpassword', '$facepath', '$bookname', '$booksurname','$booknumber', '$bookgender');";
       
       $result = mysqli_query($conn, $sql);
   
       return $result;
   }
   
   
   
   function  updateHouse($conn, $faceID, $bookname, $booksurname, $booknumber, $bookgender) {
               
      
       $query = "UPDATE `tbl_users` SET `name`='$bookname',`surname`='$booksurname',`number`='$booknumber',`gender_fk`='$bookgender' WHERE  `faceID`=$faceID;";
       $result = mysqli_query($conn, $query);
       return $result;
   }
   
   
   

   
   
   function Showprofileface($conn){
       $query = "SELECT faceID, tb1.email as bookemail, tb1.password as bookpassword , tb1.facepath as facepath , tb1.name as bookname, tb1.surname as booksurname , tb1.number as booknumber , tb1.gender_fk as bookgender  FROM `tbl_users` tb1 INNER JOIN `tbl_gen` tb2 ON tb1.gender_fk = tb2.genID  ;";
   
       $result = mysqli_query($conn, $query);
       return $result;
   }

   function gentypeDb($conn){
    $query = "SELECT * FROM `tbl_gen`";
    $result = mysqli_query($conn, $query) or die("error in gender types");

    return $result;
    }



    function delface($conn, $faceID){
        $query = "DELETE FROM `tbl_users` WHERE `faceID` = '$faceID'";

        
        $result = mysqli_query($conn, $query)
        or die("Error in deleteVeh2 query " .mysqli_error($conn));

        return $result;
    }


    function getshowprofile($conn) {
        $query = "SELECT `faceID`, `email`, `password`, `facepath`, `name`, `surname`, `number` FROM `tbl_users`;";
    
        
        $result = mysqli_query($conn, $query)
        or die("Error in getVehicles query " .mysqli_error($conn));

        return $result;

    }




}



