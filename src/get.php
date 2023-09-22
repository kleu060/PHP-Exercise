<?php
    // namespace App;

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    
    // require_once("../inc.php");
    require_once __DIR__ . '/../vendor/autoload.php';

    require_once("../config.php");

    // use App\Company;
    // use App\Employee;

    
    $action = isset($_GET['action']) ? $_GET['action'] : "";
    if ( $action != ""){
        switch ($action){
            case "getemployee":
                $result = getEmployeesAPI();
                break;
            case "getCompanySalaryAverage":
                getCompanySalaryAverage();
                break;
            default:
                return;
        }
        
    }
    else{
        return;
    }



    /**
     *  API to get all Employees
     *  
     *  @return JSON String
    */
    function getEmployeesAPI(): void
    {
        $employees = \App\Employee::getAllEmployees();
        // print_r($employees);
        echo json_encode( $employees, true );
    }

    /**
     *  API to get company  salary average
     *  
     *  @return JSON String
    */
    function getCompanySalaryAverage(): void
    {
        $average = \App\Employee::getAverageSalary();
        echo json_encode($average);
    }
?>