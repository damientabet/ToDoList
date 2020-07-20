ToDoList
========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1

## Processus d'installation  
### Étape 1  
Assurez-vous d'avoir Git installé et à jour sur votre machine  

www.git-scm.com  
### Étape 2

Cloner le repository sur votre serveur local  

``git clone https://github.com/damientabet/ToDoList.git``  

### Étape 3

Bien s'assurer que composer est installé et à jour sur votre machine  

www.getcomposer.org/doc/00-intro.md  

### Étape 4

Après avoir installé composer, veuillez lancer ``composer install`` à la racine de votre projet.  
Toutes les dépendances vont s'installer et se stocker dans le dossier **/vendor**.

### Étape 5  

Modifier les accès à votre base de données dans le fichier ``.env [DATABASE_URL] (l.28)``. 

### Étape 6  

Créer la base de données en utilisant exécutant la commande suivante :
``php bin/console doctrine:database:create``  

### Étape 7  

Créer les tables dans la base de données en utilisant exécutant la commande suivante :  
``php bin/console doctrine:schema:create``

### Étape 8  

Installer les data fixtures afin de pouvoir interagir avec le site.  
``php bin/console doctrine:fixtures:load``  

### Étape 9  

Si vous êtes en local, vous pouvez démarrer le serveur de Symfony avec la commande :  
``php bin/console server:run`` 

### Étape 10

Si vous installez le projet sur une serveur, n’oubliez pas de faire pointer votre domaine vers le fichier ``/public``  

### Étape 11

Voici les identifiants du compte administrateur pour pouvoir ajouter de nouveaux utilisateurs et/ou tâches.  
-  Email : administrateur@todolist.com  
-  Mot de passe : admintest