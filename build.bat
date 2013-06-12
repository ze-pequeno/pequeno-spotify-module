@ECHO OFF
composer update --prefer-source --dev & ^
.\vendor\bin\phpunit -c .\phpunit.xml --coverage-clover .\build\logs\clover.xml --coverage-html .\build\coverage --exclude-group Performance & ^
.\vendor\bin\phpunit --group=Functional & ^
.\vendor\bin\phpcs -a --standard=PSR2 .\src\ .\tests\ & pause