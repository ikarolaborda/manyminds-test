USE manyminds;

CREATE TABLE users (
					   id INT(11) NOT NULL AUTO_INCREMENT,
					   username VARCHAR(255) NOT NULL,
					   email VARCHAR(255) NOT NULL,
					   password VARCHAR(255) NOT NULL,
					   ip_address VARCHAR(255),
					   PRIMARY KEY (id)
);

CREATE TABLE departments (
							id INT(11) NOT NULL AUTO_INCREMENT,
							name VARCHAR(255) NOT NULL,
							PRIMARY KEY (id)
);

CREATE TABLE addresses (
							id INT(11) NOT NULL AUTO_INCREMENT,
							street VARCHAR(255) NOT NULL,
							number VARCHAR(255) NOT NULL,
							neighborhood VARCHAR(255) NOT NULL,
							city VARCHAR(255) NOT NULL,
							state VARCHAR(255) NOT NULL,
							PRIMARY KEY (id)
);

CREATE TABLE employees_adresses (
									id INT(11) NOT NULL AUTO_INCREMENT,
									employee_id INT(11) NOT NULL,
									address_id INT(11) NOT NULL,
									PRIMARY KEY (id)
);

CREATE TABLE employees_phones (
									id INT(11) NOT NULL AUTO_INCREMENT,
									employee_id INT(11) NOT NULL,
									phone VARCHAR(255) NOT NULL,
									PRIMARY KEY (id)
);

CREATE TABLE employees (
    					id INT(11) NOT NULL AUTO_INCREMENT,
						name VARCHAR(255) NOT NULL,
						employee_number VARCHAR(255) NOT NULL,
						employee_cpf VARCHAR(255) NOT NULL,
						department_id INT(11) NOT NULL,
						employee_user_id INT(11) NOT NULL,
						employee_status INT(11) NOT NULL,
						PRIMARY KEY (id)
);
ALTER TABLE employees ADD CONSTRAINT fk_employees_departments FOREIGN KEY (department_id) REFERENCES departments(id);
ALTER TABLE employees ADD CONSTRAINT fk_employees_users FOREIGN KEY (employee_user_id) REFERENCES users(id);
ALTER TABLE employees_phones ADD CONSTRAINT fk_employees_phones_employees FOREIGN KEY (employee_id) REFERENCES employees(id);

INSERT INTO users (username, password) VALUES ('admin', 'admin');
