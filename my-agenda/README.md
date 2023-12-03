# trainingSymfo


## Créer un projet 

- composer create-project symfony/website-skeleton my-project

- se mettre dans le projet : cd my-project

## Base de données 

### Connexion à la base
- Lancer wamp
- Mettre dans le .env la connexion à la bdd : DATABASE_URL="mysql://root:@127.0.0.1:3306/maBase?serverVersion=8&charset=utf8mb4"
- php bin/console doctrine:database:create
- créer une table :  php bin/console make:entity
- php bin/console make:migration
- php bin/console doctrine:migrations:migrate
- créer un utilisateur : 
    - php bin/console make:user
    - formulaire d'inscription : symfony console make:registration-form
    - formulaire de connexion : symfony console make:auth   
    - changer la route dans Security > LoginAuthenticator > puis mettre le nom de la route    
    - dans security.yaml changer le nom de la route target pour mettre app_login pour le logout

### Créer un controller + une page 
- php bin/console make:controller

### Créer un formulaire : 
- php bin/console make:form        