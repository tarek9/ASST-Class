<?php

/*using the pdo to connect to the database*/
try {
$handler = new PDO ('mysql:host=localhost;dbname=employees','root','user');

/*setAttribute is used to set several attributes of PDO | ATTR_ERRMODE is used for error reporting |
ERRMODE_EXCEPTION is used to reflect the error code and error information*/

$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {

echo $e->getMessage(); /*getMessage() will show the error message*/
die();
}


/*this the SQL query*/
$query = $handler->query('SELECT employees.first_name, employees.last_name, salaries.salary, titles.title, departments.dept_name FROM employees INNER JOIN salaries ON employees.emp_no = salaries.emp_no INNER JOIN titles ON employees.emp_no = titles.emp_no INNER JOIN dept_emp ON employees.emp_no = dept_emp.emp_no INNER JOIN departments ON dept_emp.dept_no = departments.dept_no ORDER BY salaries.salary DESC LIMIT 5');

/* fetchAll used to return an array containing all of the result set rows */
/* FETCH_ASSOC used to return an associative array */
$r = $query->fetchAll(PDO::FETCH_ASSOC);
echo '<pre>', print_r($r), '/<pre>';

/* json_encode returns the JSON representation of a value */
$json = json_encode( $r );
/* json_data converts JSON object | file_put_contents writes a string to a file */
$json_data = json_encode($r); file_put_contents('employees.json', $json_data);

?>