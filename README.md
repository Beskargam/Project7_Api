# Project7_Api

Openclasrooms PHP/Symfony project 7 : Api
 
developper : AureDev
 
Developped with : PHPStorm, WAMP64, Postman

languages : html, css, javascript, Symfony, Doctrine, Twig

Bundle : JMSSerializer, FOSRestBundle, CSAGuzzleBundle, NelmioAPIBundle

installation guide :

    Clone the github project
    Create a mysql database and name it "project7_db" (php bin/console doctrine:database:create)
    Update the DATABASE_URL in your .env file
    Run a Doctrine migration to create the tables (php bin/console doctrine:migrations:migrate or php bin/console d:m:m)
    Load a couple of fake articles with the fixtures load (php bin/console doctrine:fixtures:load or php bin/console d:f:l)
    Run the app on your localhost with the Symfony developpement server ! (cd project -> php bin/console server:run)

Website : https://app-bilemo.herokuapp.com/

Documentation : https://app-bilemo.herokuapp.com/api/doc
