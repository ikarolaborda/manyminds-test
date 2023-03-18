USE manyminds;

CREATE TABLE users (
					   id INT(11) NOT NULL AUTO_INCREMENT,
					   username VARCHAR(255) NOT NULL,
					   password VARCHAR(255) NOT NULL,
					   ip_address VARCHAR(255),
					   PRIMARY KEY (id)
);

INSERT INTO users (username, password) VALUES ('admin', 'admin');
