<?php
    namespace App;

    class Company{

        public int $id;
        public string $company_name;

        /**
         * Company Constructor
         */
        function __construct( $id = -1, $company_name= ""){
            $this->id = $id;
            $this->company_name = $company_name;

        }

        /**
         * Insert new Company to database
         * 
         * @param $company_name
         * @param $conection mysqli connection
         * 
         * @return $company_id
         */
        public static function  insertNewCompany($company_name, $connection): ?int
        {
            $stmt = $connection->prepare("insert into companies (`company_name`) value(?)");

            $stmt->bind_param("s", $company_name);
            if ($stmt->execute()) {
                $company_id = $connection->insert_id;
                return $company_id;
            } else {
                $stmt->close();
                return null;
            }     
        }

        /** 
         *  Check if company exist in the database, if Company exist return its id, if not exist, insert a new company and return its id
         *  
         *  @param $company_name
         *  @param $conection mysqli connection
         *  @return $company_id
         */
        public static function getCompanyId($company_name, $connection): int
        {

            $stmt = $connection->prepare("select id from companies where company_name=?");
            $stmt->bind_param("s", $company_name);
            $stmt->execute();
            $result = $stmt->get_result();

            $stmt->close();
            // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $company_id = "";
            if ( $result->num_rows == 0){
                $company_id = self::insertNewCompany($company_name, $connection);

            }
            else{
                $row = $result->fetch_assoc();
                $company_id = $row["id"];
            }
            return $company_id;
            

        }
    }
?>