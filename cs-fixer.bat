@ECHO OFF
.\vendor\bin\php-cs-fixer fix .\src -v & ^
.\vendor\bin\php-cs-fixer fix .\tests -v