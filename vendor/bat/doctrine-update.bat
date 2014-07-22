@ECHO OFF

call ..\bin\doctrine-module orm:schema-tool:update --force

pause 