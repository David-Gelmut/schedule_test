CREATE TABLE schedules (
       id INT AUTO_INCREMENT PRIMARY KEY ,
       region_id int,
       courier_id int,
       date DATE NOT NULL,
       FOREIGN KEY (region_id) REFERENCES regions (id) ON DELETE CASCADE,
       FOREIGN KEY (courier_id) REFERENCES couriers (id) ON DELETE CASCADE
);