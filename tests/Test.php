<?php

use App\Company;
use App\Employee;

use PHPUnit\Framework\TestCase;

class Test extends TestCase{




    public function test_insert_employee(){
        global $connection;
        $connection = $this->getMockBuilder(mysqli::class)
            ->disableOriginalConstructor()
            ->getMock();
            
        $statement = $this->getMockBuilder(mysqli_stmt::class)
            ->disableOriginalConstructor()
            ->getMock();

        // $mysqliMock = $this->createMock(mysqli::class);
        $connection->method('prepare')->willReturn($statement);  
        $statement->method('execute')->willReturn(true);  

        $company = new Company("1", "Test Company");
        $employee = new Employee($company, "Peter", "peter@asknicely.com", "10000", "1");
        $result = $employee->insertNewEmployee($employee, $connection);
        $this->assertTrue($result);


    }

    public function test_email_update(){
        global $connection;
        $connection = $this->getMockBuilder(mysqli::class)
            ->disableOriginalConstructor()
            ->getMock();
            
        $statement = $this->getMockBuilder(mysqli_stmt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $connection->method('prepare')->willReturn($statement);  
        $statement->method('execute')->willReturn(true);  

        $result = Employee::UpdateEmail("1", "test@gmail.com",$connection);
        $this->assertTrue($result);
    }



    public function test_get_employee(){
        $connection = $this->getMockBuilder(mysqli::class)
            ->disableOriginalConstructor()
            ->getMock();

        $statement = $this->getMockBuilder(mysqli_stmt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockResult = $this->getMockBuilder(mysqli_result::class)
            ->disableOriginalConstructor()
            ->getMock();

        $connection->method('prepare')->willReturn($statement);
        $statement->method('execute')->willReturn(true);
        $statement->method('get_result')->willReturn($mockResult);

        $company = new Company("1", "Test Company");

        $sampleRowData = [
            ["company_id" => 1, "company_name" => "Test Company", "employee_id" => 1, "employee_name" => "Ka On Leung", "email_address" => "kleu060@gmail.com", "salary" => 20000],
        ];

        $mockResult->method('fetch_assoc')->will($this->onConsecutiveCalls(...$sampleRowData));
        $result = Employee::getAllEmployees($connection);
        $this->assertCount(count($sampleRowData), $result);

        foreach ($result as $index => $employee) {
            $this->assertInstanceOf(Employee::class, $employee);
            $this->assertEquals($sampleRowData[$index]["employee_id"], $employee->id);
            $this->assertEquals($sampleRowData[$index]["employee_name"], $employee->employee_name);
            $this->assertEquals($sampleRowData[$index]["email_address"], $employee->email_address);
            $this->assertEquals($sampleRowData[$index]["salary"], $employee->salary);
        }
    }


    public function test_get_employee_fail(){
        $connection = $this->getMockBuilder(mysqli::class)
            ->disableOriginalConstructor()
            ->getMock();

        $statement = $this->getMockBuilder(mysqli_stmt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockResult = $this->getMockBuilder(mysqli_result::class)
            ->disableOriginalConstructor()
            ->getMock();

        $connection->method('prepare')->willReturn($statement);
        $statement->method('execute')->willReturn(false);

        $result = Employee::getAllEmployees($connection);
        $this->assertNull( $result ); 
    }

    public function test_insert_new_employee_success(){
        $connection = $this->getMockBuilder(mysqli::class)
            ->disableOriginalConstructor()
            ->getMock();

        $statement = $this->getMockBuilder(mysqli_stmt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $connection->method('prepare')->willReturn($statement);
        $statement->method('bind_param')->willReturn(true);
        $statement->method('execute')->willReturn(true);

        $company =  new Company("1", "Test Company");
        $employee = new Employee($company, "Ka On Leung",  "kleu060@gmail.com" , 4000000, 1);
        $result = $employee->insertNewEmployee($employee, $connection);
        $this->assertTrue($result);

    }


    public function test_insert_new_employee_fail(){
        $connection = $this->getMockBuilder(mysqli::class)
            ->disableOriginalConstructor()
            ->getMock();

        $statement = $this->getMockBuilder(mysqli_stmt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $connection->method('prepare')->willReturn($statement);
        $statement->method('bind_param')->willReturn(true);
        $statement->method('execute')->willReturn(false);

        $company =  new Company("1", "Test Company");
        $employee = new Employee($company, "Ka On Leung",  "kleu060@gmail.com" , 4000000, 1);
        $result = $employee->insertNewEmployee($employee, $connection);
        $this->assertFalse($result);

    }


    public function test_get_average_salary(){
        $connection = $this->getMockBuilder(mysqli::class)
            ->disableOriginalConstructor()
            ->getMock();

        $statement = $this->getMockBuilder(mysqli_stmt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockResult = $this->getMockBuilder(mysqli_result::class)
        ->disableOriginalConstructor()
        ->getMock();

        $connection->method('prepare')->willReturn($statement);
        $statement->method('bind_param')->willReturn(true);
        $statement->method('execute')->willReturn(true);
        $expectedQuery = "SELECT companies.company_name, AVG(salary) AS avg FROM employees INNER JOIN companies ON employees.company_id = companies.id GROUP BY company_id";

        $sampleData = [
            ["company_name" => "The Web Co", "avg" => 20100],

        ];
        $statement->method('execute')->willReturn(true);
        $statement->method('get_result')->willReturn($mockResult);
        $mockResult->method('fetch_assoc')->will($this->onConsecutiveCalls(...$sampleData));

        $result = Employee::getAverageSalary($connection);
        $expectedResult = [
            ["company_name" => "The Web Co", "average" => "20,100.00"],
        ];
        $this->assertEquals($expectedResult, $result);

    }

    

    



    

}
?>