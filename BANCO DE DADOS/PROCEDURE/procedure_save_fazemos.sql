CREATE PROCEDURE `sp_fazemos_save`(
pidfazemos int(11),
pdestitulo text,
pdestext text
)
BEGIN
	
	IF pidfazemos > 0 THEN
		
		UPDATE tb_fazemos
        SET 
			destitulo = pdestitulo,
            destext = pdestext
        WHERE idfazemos = pidfazemos;
        
    ELSE
		
		INSERT INTO tb_fazemos (destitulo, destext) 
        VALUES(pdestitulo, pdestext);
        
        SET pidfazemos = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_fazemos WHERE idfazemos = pidfazemos;
    
END
