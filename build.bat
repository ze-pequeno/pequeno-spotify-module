@ECHO OFF
composer install --prefer-source --dev & ^
.\vendor\bin\phpunit -c .\phpunit.xml --coverage-clover .\build\logs\clover.xml --exclude-group Performance & ^
.\vendor\bin\phpunit --group=Functional & ^
.\vendor\bin\phpcs --standard=PSR2 .\src\ .\tests\ & pause