@ECHO OFF
composer update --prefer-source --dev & ^
.\vendor\bin\php-cs-fixer fix .\src -v --dry-run & ^
.\vendor\bin\php-cs-fixer fix .\tests -v --dry-run & ^
.\vendor\bin\phpunit -c .\phpunit.xml --coverage-clover .\build\logs\clover.xml --coverage-html .\build\coverage & pause