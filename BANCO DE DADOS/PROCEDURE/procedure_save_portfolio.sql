CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_portfolios_save`(
pidport int(11),
pdestitulo text,
pdestexto text
)
BEGIN
	
	IF pidport > 0 THEN
		
		UPDATE tb_portfolios
        SET 
			destitulo = pdestitulo,
            destexto = pdestexto
        WHERE idport = pidport;
        
    ELSE
		
		INSERT INTO tb_portfolios (destitulo, destexto) 
        VALUES(pdestitulo, pdestexto);
        
        SET pidport = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_portfolios WHERE idport = pidport;
    
END