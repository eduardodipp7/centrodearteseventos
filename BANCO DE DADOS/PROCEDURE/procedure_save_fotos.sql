CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_fotos_save`(
pidfoto int(11),
pdesfoto varchar(100)
)
BEGIN
	
	IF pidfoto > 0 THEN
		
		UPDATE tb_fotos
        SET 
			desfoto = pdesfoto
        WHERE idfoto = pidfoto;
        
    ELSE
		
		INSERT INTO tb_fotos (desfoto) 
        VALUES(pdesfoto);
        
        SET pidfoto = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_fotos WHERE idfoto = pidfoto;
    
END