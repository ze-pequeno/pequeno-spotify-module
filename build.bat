@ECHO OFF
composer update --prefer-source --dev & ^
call .\cs-fixer.bat & ^
.\vendor\bin\phpunit -c .\phpunit.xml --coverage-clover .\build\logs\clover.xml & pause