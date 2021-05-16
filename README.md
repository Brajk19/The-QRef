# The-QRef
Project for SofaScore Backend Academy

"The QRef ?" is MVC web application for creating and solving quizzes.

    Features:

     -create and edit your own quizzes
  
     -solve quizzes made by other users
  
     -post comments on quiz (if author allowed that)
  
     -check out stats for every quiz
  
     -"challenge mode" where questions are randomly pulled from all quizzes in app



Installation instructions:
1. clone this repository
2. set DocumentRoot to app folder in httpd.conf, example:

      DocumentRoot "X:/xampp/htdocs/The-QRef"
      
      <Directory "X:/xampp/htdocs/The-QRef">

3. create database from qref.sql (some changes regarding username/password/host/databaseName might be requried in model/Database.php)
