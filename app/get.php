<?php

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    
    // require_once("../inc.php");
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once("../config.php");
    
    $action = isset($_GET['action']) ? $_GET['action'] : "";
    if ( $action != ""){
        switch ($action){
            case "getemployee":
                $result = getEmployeesAPI($connection);
                break;
            case "getCompanySalaryAverage":
                getCompanySalaryAverage($connection);
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
     *  API to get all Employees
     *  
     * @param $connection mysqli connection
     *  @return JSON String
    */
    function getEmployeesAPI($connection): void
    {
        $employees = \App\Employee::getAllEmployees($connection);
        // print_r($employees);
        echo json_encode( $employees, true );
    }

    /**
     *  API to get company  salary average
     * 
     *  @param $connection mysqli connection
     *  @return JSON String
    */
    function getCompanySalaryAverage($connection): void
    {
        $average = \App\Employee::getAverageSalary($connection);
        echo json_encode($average);
    }
?>