<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    require_once __DIR__ . '/../vendor/autoload.php';
    // require_once("../inc.php");
    require_once("../config.php");

    use \App\Company;
    use \App\Employee;
    $action = isset($_POST['action']) ? $_POST['action'] : "";
    if ( $action != ""){
        switch ($action){
            case "importcsv":
                $result = importCSV($connection);
                break;
            case "updateEmployeeEmail":
                $result = updateEmployeeEmail($connection);
                break;
            default:
                http_response_code(400);
                $res = array("message" => "Unknown action");
                echo json_encode($res);
                return;
        }
        
    }
    else{
        http_response_code(400);
        $res = array("message" => "Action not defined");
        echo json_encode($res);
        return;
    }




    /**
     * import csv and insert employee data to the database
     * 
     * @param $connection mysqli connection
     */
    function importCSV($connection): void
    {

        $tmp_file = $_FILES['file']['tmp_name'];
        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if ($ext !== 'csv') {
            http_response_code(406);
            $res = array("message" => "Invalid file format");
            echo json_encode($res);
            return;
        }

        $rows = array_map('str_getcsv', file($tmp_file));
        
        //Remove header row
        array_shift($rows);
        // print_r($rows);

        $employee_added = 0;
        foreach ($rows as $row)
        {
            $company_id = Company::getCompanyId($row[0], $connection);
            if ( $company_id != null){
                $isEmployeeExist = Employee::checkEmployeeExist($row[1], $connection);
                if ( $isEmployeeExist === false )
                {
                    $company = new Company ($company_id, $row[0]);
                    $employee = new Employee($company, $row[1], $row[2], $row[3]);
                    // $insert = "insert into employees (`company_id`, `employee_name` , `email_address`, `salary`) values ('".$company_id."', '".$row[1]."', '".$row[2]."', '".$row[3]."')";
                    // $connection->query($insert);
                    $employee->insertNewEmployee($employee, $connection);
                    $employee_added ++;
                }
            }


        }
        $res = array("employee_added" => $employee_added);
        echo  json_encode($res);
    }

    /**
     * Update EmployeeEmail
     * 
     * @param $connection mysqli connection
     */
    function updateEmployeeEmail($connection)
    {

        $id = $_POST["employee_id"];
        $email = $_POST["email_address"];
        $result = Employee::UpdateEmail($id, $email, $connection);
        $res = array("status" => $result);
        echo json_encode($res);
         
    }

?>