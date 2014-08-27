@ECHO OFF

call cd ..
call cd ..
set php=C:\xampp\php\php.exe
set /p mname=Enter module name: 
set module=%cd%\vendor\zendframework\zftool\zf.php create module %mname%
call %php% %module% 

set controller=%cd%\vendor\zendframework\zftool\zf.php create controller %mname% %mname% 
call %php% %controller% 


call pause