create table companies(
    id int(15) NOT NULL AUTO_INCREMENT,
    company_name varchar(255),
    PRIMARY KEY (id)      
);

create table employees (
    id int(15) NOT NULL AUTO_INCREMENT,
    company_id int(15),
    employee_name varchar(255), 
    email_address varchar(255),
    salary float (10, 2),
    PRIMARY KEY (id),
    FOREIGN KEY (company_id) REFERENCES companies(id)
);