<?php
    namespace App;

    use App\Company;

    class Employee{

        public int $id;
        public Company $company;
        public string $employee_name;
        public string $email_address;
        public float $salary;


        /**
         * Employee Constructor
         */
        function __construct($company, $employee_name, $email_address, $salary, $id = -1){
            
            $this->id = $id;
            $this->company = $company;
            $this->employee_name = $employee_name;
            $this->email_address = $email_address;
            $this->salary = $salary;

        }


        /**
         * Insert new employee to database
         * 
         * @param $employee
         * @param $conection mysqli connection
         * @return bool
        */
        public function insertNewEmployee($employee, $connection): bool
        {
            $stmt = $connection->prepare("insert into employees (`company_id`, `employee_name` , `email_address`, `salary`) values (?,?,?,?)");

            $stmt->bind_param("issi", $employee->company->id, $employee->employee_name, $employee->email_address, $employee->salary);
            if ($stmt->execute()) {
                $stmt->close(); 
                return true;
            } else {
                $stmt->close();
                return false;
            }   
        }

        /**
         *  Check if Employee exist in the database.  Assume employee name is always unique
         * 
         *  @param $email
         *  @param $conection mysqli connection
         *  @return bool $is_exist
         */
        public static function checkEmployeeExist($employee_name, $connection): bool
        {
            $stmt = $connection->prepare("select count(*) as count from employees where employee_name=?");
            $stmt->bind_param("s", $employee_name);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ( $row["count"] > 0 )
            {
                return true;
            }
            else
            {
                return false;
            }
            
        }

        /**
         *  Get all Employees from the database
         *  
         *  @param $conection mysqli connection
         *  @return array $employees;
         */
        public static function getAllEmployees($connection): ?array
        {

            $stmt = $connection->prepare("select companies.id company_id, companies.company_name, employees.id employee_id, employee_name, email_address, salary from employees inner join companies on employees.company_id = companies.id");
            if ( $stmt->execute() )
            {
                $result = $stmt->get_result();
                $employees = [];
                while ($row = $result->fetch_assoc() )
                {
                    $company = new Company($row["company_id"], $row["company_name"]);
                    $employee = new Employee( $company, $row["employee_name"], $row["email_address"], $row["salary"], $row["employee_id"]);
                    $employees[] = $employee;
                }
                return $employees;
            }
            return null;
        }

        /**
         *  Get all Employees from the database
         * 
         *  @param $employee_id
         *  @param $email_address
         *  @param $conection mysqli connection
         *  @return  bool;
         */
        public static function updateEmail( $employee_id, $email_address, $connection): bool
        {
            $stmt = $connection->prepare("update employees set email_address=? where id=?");
            $stmt->bind_param("si", $email_address, $employee_id);
            if ($stmt->execute()) {
                $stmt->close(); 
                return true;
            } else {
                $stmt->close();
                return false;
            }            
            
        }

        /**
         *  Get average salary of each company
         * 
         * @param $conection mysqli connection
         * @return array $comaeny 
         */
        public static function getAverageSalary($connection): array
        {
            $stmt = $connection->prepare(" select companies.company_name , avg(salary) as avg from employees inner join companies on employees.company_id = companies.id group by company_id");
            $stmt->execute();
            $result = $stmt->get_result();
            $company = [];
            while ($row = $result->fetch_assoc() )
            {
                $company[] = array(
                    "company_name" => $row["company_name"],
                    "average" => number_format($row["avg"],2),
                );
            }
            return $company;
        }
        


    }
?>