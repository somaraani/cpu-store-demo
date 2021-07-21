/* Create database */
CREATE DATABASE db;

/* Create CPU table */
CREATE TABLE Cpu (
    product_id INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    manufacturer varchar(255) NOT NULL,
    model varchar(255) NOT NULL, 
    speed int NOT NULL,
    cores int NOT NULL,
    img varchar(255),
);

/* Create Inventory table */
CREATE TABLE Inventory (
    id INT NOT NULL,
    quantity INT NOT NULL,
    price FLOAT NOT NULL,
    CONSTRAINT PK_InventoryId PRIMARY KEY NONCLUSTERED (id),
    CONSTRAINT FK_InvetoryId_Product FOREIGN KEY (id) REFERENCES Cpu (product_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

/* Insert sample data (FOR TESTING CONVENIENCE) */ 
INSERT INTO Cpu VALUES("Intel", "i7 7700k", 4200, 4, "https://en.wikichip.org/w/images/thumb/d/d8/core_i7_logo_%282015%29.png/250px-core_i7_logo_%282015%29.png");
INSERT INTO Inventory VALUES (1, 6, 399.99);

INSERT INTO Cpu VALUES("AMD", "Ryzen 7 3700x", 3900, 8, "https://cdn-reichelt.de/bilder/web/xxl_ws/E200/AMD_R7-3800XT_01.png");
