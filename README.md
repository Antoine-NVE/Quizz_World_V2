Le contenu :
- page d'accueil avec affichage des catégories complètes et actives, ainsi qu'un système de pagination
- formulaires de connexion et d'inscription
- profil avec quelques stats et possibilité de créer ses quizz
- page d'administration avec gestion d'un peu tout

---

Les éléments à installer et/ou lancer :
- Composer
- Symfony CLI
- MailHog
- phpMyAdmin

---

Les commandes :
- Installer les dépendances :

	  composer install

- S'assurer que tout est ok :
  
	  symfony check:requirements

- Créer la base de données quizz_world :
  
	  symfony console doctrine:database:create

- Ajouter les tables :
  
	  symfony console doctrine:migrations:migrate

- Ajouter du contenu à la base :
  
	  symfony console doctrine:fixtures:load

- Démarrer le serveur :
  
	  symfony serve

---

Informations :
- Les DataFixtures créent 9 catégories complètes (donc chacune composée de 3 questionnaires, 30 questions et 120 propositions), 5 utilisateurs (admin@quizzworld.fr avec comme mdp "admin", et les 4 autres sont aléatoires avec comme mdp "password") et enfin un certain nombre de scores aléatoires
- Les catégories suivent toujours le pattern évoqué ci-dessus, celui-ci doit être respecté pour que les catégories s'affichent à l'accueil
- Il arrive qu'il y ait un doublon sur un pseudo à cause de Faker, ne pas hésiter à relancer la commande pour les DataFixtures
