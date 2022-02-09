#Loginet Recipe Ingredients Recalculator

    1. Git clone application
    2. Enter into the directory
    3. Run: composer install
    4. Run: symfony server:start
    5. Open in browser: http://127.0.0.1:8000/recalculate/ingredients
    5.1 Default servings is 1
    5.2 If you want to change servings add a number into the url, for example:
        - http://127.0.0.1:8000/recalculate/ingredients/5
        - http://127.0.0.1:8000/recalculate/ingredients/4
    5.3 Run Unit tests:
        - php bin/phpunit


#Other information:
    Ingredients json file it is in the public/assets directory.