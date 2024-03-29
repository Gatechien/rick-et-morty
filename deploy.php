<?php
namespace Deployer;

require 'recipe/symfony.php';

// --------------------------
// modification des paramètres par défaut
// --------------------------

// on demande à inclure les packages de dev
set('composer_options', '--verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader');

// ---------------------------------------------------------------------------
// Paramètres de notre application
// ---------------------------------------------------------------------------
set("env_database", "mysql://curie_admin:curie_admin@127.0.0.1:3306/rick-et-morty?serverVersion=mariadb-10.3.25&charset=utf8mb4");

// ---------------------------------------------------------------------------
// Paramètres de connexion au serveur distant
// ---------------------------------------------------------------------------

// Nom du fichier contenant la clé SSH permettant de s'authentifier auprès
// du serveur distant (va chercher dans votre répertoire local ~/.ssh de
// l'utilisateur courant).
// Généralement requis pour se connecter à un serveur mais pas nécessaire
// pour se connecter à notre VM Kourou.
// set('ssh_key_filename', 'nom_du_fichier_contenant_la_cle_ssh.pem');

// Adresse du serveur distant (adresse IP ou DNS public)
// set('remote_server_url','adresse_ip_ou_dns_public_du_serveur');
set('remote_server_url','gatechien-server.eddi.cloud');
//set('remote_server_url','virginieboissiere-server.eddi.cloud');

// Nom du compte utilisateur sur le serveur distant/
// C'est cet utilisateur qui exécutera les commandes distantes.
// set('remote_server_user','nom_utilisateur_distant');
set('remote_server_user','student');

// ---------------------------------------------------------------------------
// Paramètres de déploiement spécifiques à notre projet
// ---------------------------------------------------------------------------

// Répertoire cible (sur le serveur distant) où le code source sera déployé
// => le répertoire sera créé s'il n'existe pas
set('remote_server_target_repository', '/var/www/html/rick-et-morty');

// Adresse du dépôt Github contenant le code source du projet 
set('repository', 'git@github.com:Gatechien/rick-et-morty.git');

// Nom de la branche à déployer
set('repository_target_branch', 'main');

// ---------------------------------------------------------------------------
// Autres paramètres concernant le déploiement
// ---------------------------------------------------------------------------

// [Optional]
// Ce paramètre permet d'avoir le retour de la commande "git clone"
set('git_tty', true); 

// On ne veut pas envoyer de statistiques à Deployer.org (même de façon anonyme)
set('allow_anonymous_stats', false);

// Nombre de releases à conserver (5 par défaut, -1 pour illimité)
set('keep_releases', 3);

// ---------------------------------------------------------------------------
// Définition des paramètres de déploiement pour le serveur de 'production'
// ---------------------------------------------------------------------------

host('prod')
    // On précise l'adresse du serveur distant.
    // Les doubles accolades {{my_parameter}} permettent de récupérer
    // la valeur d'un paramètre défini avec set('my_parameter','my_value');
    ->set('hostname', '{{remote_server_url}}')
    // Précise le chemin absolu (sur la machine distante) du répertoire
    // dans lequel le code sera déployé.
    // par exemple : /var/www/html/mywebsite
    ->set('deploy_path', '{{remote_server_target_repository}}')
    // Si la branche n'est pas spécifiée, Deployer utilise le nom de la branche
    // actuelle du dépôt Git local dans lequel on se trouve.
    ->set('branch', '{{repository_target_branch}}')
    // Précise le nom de l'utilisateur (sur la machine distante) qui sera utilisé
    // pour établir la connexion SSH et exécuter les commandes.
    ->set('remote_user', '{{remote_server_user}}');
    // Chemin du fichier (sur votre machine locale) contenant la clé SSH permettant
    // d'établir la connexion SSH.
    // Généralement requis pour se connecter à un serveur mais pas nécessaire
    // pour se connecter à notre VM Kourou.
    // ->set('identity_file','~/.ssh/{{ssh_key_filename}}')

// ---------------------------------------------------------------------------
// Définition des tâches (tasks)
// ---------------------------------------------------------------------------

desc('Création de la base de données');
task('init:database', function() {
    run('{{bin/console}} doctrine:database:create');
});

//desc('Supression base de données');
//task('init:database:drop', function() {
    //run('{{bin/console}} doctrine:database:drop --if-exists --no-interaction --force');
//});

desc("Création des fixtures");
task('init:fixtures', function () { 
    run('yes | {{bin/console}} doctrine:fixtures:load');
});

desc('écraser le .env.local PUIS écrire les paramètres de PROD');
task('init:config:write:prod', function() {
    // {{remote_server_target_repository}} == '/var/www/html/NB-services-et-soin
    run('echo "APP_ENV=prod" > {{remote_server_target_repository}}/shared/.env.local');
    run('echo "DATABASE_URL={{env_database}}" >> {{remote_server_target_repository}}/shared/.env.local');
});

desc('écraser le .env.local PUIS écrire les paramètres de DEV');
task('init:config:write:dev', function() {
    run('echo "APP_ENV=dev" > {{remote_server_target_repository}}/shared/.env.local');
    run('echo "DATABASE_URL={{env_database}}" >> {{remote_server_target_repository}}/shared/.env.local');
});

//desc('Générer une nouvelle clef api');
//task('lexik:jwt:generate-keypair', function () {
    //run("{{bin/console}} lexik:jwt:generate-keypair");
//});

desc('Deploy project');
task('first_deploy', [
//NOTE commande terminal pour le deploiment: dep first_deploy prod -f deploy.php
    // https://deployer.org/docs/7.x/recipe/common#deployprepare
    'deploy:prepare',

    // on écrit notre fichier .env.local
    'init:config:write:dev',

    // https://deployer.org/docs/7.x/recipe/deploy/vendors#deployvendors
    'deploy:vendors',

    // https://deployer.org/docs/7.x/recipe/symfony#deploycacheclear
    'deploy:cache:clear',

    // au cas où il existe la BDD
    //'init:database:drop',

    // on crée la base de donnée
    'init:database',

    // https://deployer.org/docs/7.x/recipe/symfony#databasemigrate
    'database:migrate',

    // on lance les fixtures
    'init:fixtures',

    // on écrit notre fichier .env.local
    'init:config:write:prod',

    // on génére une nouvelle clef api
    //'lexik:jwt:generate-keypair',

    // https://deployer.org/docs/7.x/recipe/common#deploypublish
    'deploy:publish'
]);
task('prod_update', [
    //NOTE commande terminal pour  2 ee deploiment dep update_deploy prod -f deploy.php
    // https://deployer.org/docs/7.x/recipe/common#deployprepare
    'deploy:prepare',

    // https://deployer.org/docs/7.x/recipe/deploy/vendors#deployvendors
    'deploy:vendors',

    // https://deployer.org/docs/7.x/recipe/symfony#deploycacheclear
    'deploy:cache:clear',

    // https://deployer.org/docs/7.x/recipe/symfony#databasemigrate
    'database:migrate',
    
    // on génére une nouvelle clef api
    'lexik:jwt:generate-keypair',
    
    // https://deployer.org/docs/7.x/recipe/common#deploypublish
    'deploy:publish'
]);

// Facultatif, en cas d'échec du déploiement on force la suppression
// du fichier 'deploy.lock' présent dans le répertoire '.dep' qui sert
// d'indicateur de 'déploiement en cours'
after('deploy:failed', 'deploy:unlock');

