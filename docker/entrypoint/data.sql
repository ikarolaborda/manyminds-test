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

CREATE TABLE products (
						id INT(11) NOT NULL AUTO_INCREMENT,
						name VARCHAR(255) NOT NULL,
						description VARCHAR(255) NOT NULL,
						price DECIMAL(10,2) NOT NULL,
						slug VARCHAR(255) NOT NULL,
						image_url VARCHAR(255) NOT NULL,
						PRIMARY KEY (id)
);

CREATE TABLE orders (
						id INT(11) NOT NULL AUTO_INCREMENT,
						user_id INT(11) NOT NULL,
						date_created DATETIME NOT NULL,
						order_status INT(11) NOT NULL,
						PRIMARY KEY (id)
);

CREATE TABLE orders_status (
								id INT(11) NOT NULL AUTO_INCREMENT,
								name VARCHAR(255) NOT NULL,
								PRIMARY KEY (id)
);

CREATE TABLE orders_products (
								id INT(11) NOT NULL AUTO_INCREMENT,
								order_id INT(11) NOT NULL,
								product_id INT(11) NOT NULL,
								quantity INT(11) NOT NULL,
								PRIMARY KEY (id)
);

ALTER TABLE orders ADD CONSTRAINT fk_orders_users FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE orders ADD CONSTRAINT fk_orders_orders_status FOREIGN KEY (order_status) REFERENCES orders_status(id);
ALTER TABLE orders_products ADD CONSTRAINT fk_orders_products_orders FOREIGN KEY (order_id) REFERENCES orders(id);
ALTER TABLE orders_products ADD CONSTRAINT fk_orders_products_products FOREIGN KEY (product_id) REFERENCES products(id);
ALTER TABLE employees_adresses ADD CONSTRAINT fk_employees_adresses_employees FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE ON UPDATE CASCADE
ALTER TABLE employees_adresses ADD CONSTRAINT fk_employees_adresses_addresses FOREIGN KEY (address_id) REFERENCES addresses(id)ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE employees ADD CONSTRAINT fk_employees_departments FOREIGN KEY (department_id) REFERENCES departments(id);
ALTER TABLE employees ADD CONSTRAINT fk_employees_users FOREIGN KEY (employee_user_id) REFERENCES users(id);
ALTER TABLE employees_phones ADD CONSTRAINT fk_employees_phones_employees FOREIGN KEY (employee_id) REFERENCES employees(id);

INSERT INTO users (username, password) VALUES ('admin', 'admin');
INSERT TO orders_status (name) VALUES ('Pendente'), ('Aprovada'), ('Cancelada'), ('Entregue'), ('Finalizada');
