# SnowTricks
Un projet du parcours Développeur d'Application - PHP/Symfony d'OpenClassrooms,  
tous droits réservés [à l'école](https://github.com/oc-courses)
## Contexte
Jimmy Sweat est un entrepreneur ambitieux passionné de snowboard. Son objectif est la création d'un site collaboratif pour faire connaitre ce sport auprès du grand public et aider à l'apprentissage des figures (tricks).

Il souhaite capitaliser sur du contenu apporté par les internautes afin de développer un contenu riche et suscitant l’intérêt des utilisateurs du site. Par la suite, Jimmy souhaite développer un business de mise en relation avec les marques de snowboard grâce au trafic que le contenu aura généré.
## Conception
Vous trouverez les diagrammes UML correspondant à ce projet sur [Le Drive du projet](https://drive.google.com/drive/folders/15eAz-pWeMUEUkSBxMS6ReEp1npup5gsI?usp=sharing).

Afin de garantir le bonne apprentissage de chaque étudiant, l'accès à ce dossier est restreint et non rendu public. Merci donc de m'envoyer votre adresse Gmail afin que je puisse vous fournir l'accès.
## Plannification
L'estimation correspondant à la réalisation des Issues est disponible sur [mon planning](https://calendar.google.com/calendar?cid=ZjhpOXA0bTV1YjBwam9tNmxja284NThiazhAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ).

Là aussi, les estimations indiqués ont été donnés par rapport à mes capacités et mes connaissances. Ces durées peuvent varier d'un individu à un autre autre.
## Etat actuel du projet
**Projet validé**
## Médail obtenue
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/52e48b6139f4400684374d07e1e5ba49)](https://www.codacy.com/manual/Monrocq/SnowTricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Monrocq/SnowTricks&amp;utm_campaign=Badge_Grade)
## Installation
1. Clone the repository in your local path
2. Install [Node.js](https://nodejs.org/fr/) in your machine and check that this last is available in your PATH
3. Open a new CMD/Terminal/PowerShell and use the command `sudo npm install -g maildev` to install maildev
4. Launch maildev and open a new window on Internet "http://localhost:1080"
5. Go to your local path with the command prompt after to have [composer](https://getcomposer.org/download/)/[PHP](https://www.php.net/manual/fr/install.php)/[MySQL](https://openclassrooms.com/fr/courses/1959476-administrez-vos-bases-de-donnees-avec-mysql/1959969-installez-mysql)
  ```
  composer install
  php bin/console doctrine:database:create
  php bin/console migrate
  ```
6. You can navigate on the project with [XAMPP](https://www.apachefriends.org/fr/index.html)||[LAMP](https://doc.ubuntu-fr.org/lamp)||[MAMP](https://www.mamp.info/en/)||[WAMP](http://www.wampserver.com) - ENJOY !
