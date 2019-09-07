CREATE PROCEDURE `sp_users_delete` (
piduser INT
)
BEGIN

   DECLARE vidperson INT;
   
   SET FOREIGN_KEY_CHECKS = 0;
   
   SELECT idperson INTO vidperson
       FROM tb_users 
   WHERE iduser = piduser;
   
   DELETE FROM tb_persons WHERE idperson = vidperson;
   
   DELETE FROM tb_userspasswordsrecoveries WHERE iduser = piduser;
   DELETE FROM tb_users WHERE iduser = piduser;
   
   SET FOREIGN_KEY_CHECKS = 1;

   
END
