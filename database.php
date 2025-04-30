<?php
class Db
{
    // The database connection
    protected static $connection;

    /**
     * Connect to the database
     *
     * @return bool false on failure / mysqli MySQLi object instance on success
     */
    public function connect()
    {
        // Try and connect to the database
        if (!isset(self::$connection)) {
            // Load configuration as an array. Use the actual location of your configuration file
            $config = parse_ini_file('./config.ini');
            self::$connection = new mysqli('localhost', $config['username'], $config['password'], $config['dbname']);
        }

        // If connection was not successful, handle the error
        if (self::$connection === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            return false;
        }
        return self::$connection;
    }

    /**
     * Query the database
     *
     * @param $query The query string
     * @return mixed The result of the mysqli::query() function
     */
    public function query($query)
    {
        // Connect to the database
        $connection = $this->connect();

        // Query the database
        $result = $connection->query($query);

        return $result;
    }

    /**
     * Fetch rows from the database (SELECT query)
     *
     * @param $query The query string
     * @return bool False on failure / array Database rows on success
     */
    public function select($query)
    {
        $rows = array();
        $result = $this->query($query);
        if ($result === false) {
            return false;
        }
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * Fetch the last error from the database
     *
     * @return string Database error message
     */
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
