CREATE TABLE IF NOT EXISTS delegacion (
    delegacion_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
) ENGINE=InnoDb;

INSERT INTO delegacion(denominacion) VALUES ('La Rioja'), ('Chilecito');