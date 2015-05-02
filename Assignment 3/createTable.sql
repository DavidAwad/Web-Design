CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    firstName TEXT NOT NULL,
    lastName TEXT NOT NULL,
    email VARCHAR(100) NOT NULL,
    city TEXT NOT NULL,
    zipcode TEXT NOT NULL,
    operatingSystem TEXT NOT NULL,
    PRIMARY KEY (id),
    UNIQUE INDEX email_UNIQUE (email ASC)
);
