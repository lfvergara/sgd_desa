CREATE TABLE IF NOT EXISTS delegacion (
    delegacion_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
) ENGINE=InnoDb;

INSERT INTO delegacion(denominacion) VALUES ('La Rioja'), ('Chilecito');
ALTER TABLE `archivos` ADD `delegacion_id` INT NOT NULL DEFAULT '1' AFTER `codigo_barras`, ADD INDEX (`delegacion_id`);

ALTER TABLE `matriculados` ADD `terminos_condiciones` INT NOT NULL DEFAULT '0' AFTER `direccion_visible_web`, ADD INDEX (`terminos_condiciones`);

/* 
CREAR DIRECTORIO documentos en static
Subir terminos_condiciones.pdf
*/