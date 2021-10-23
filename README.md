# Private Hire Vehicule Reservation Module
A simple Private Hire Vehicle reservation Symfony app which uses calls to Google Maps API and Paypal API.

## About The Project

This is a personal project that I made to train me to use some usefull APIs, and can have a real utility for PHV enterprises.  
Your comments and suggestions are welcome.

### Built With

*   🐘️ PHP 8.0.9
*   ⛵ phpMyAdmin 5.0.2
*   🐬  MySQL 5.7.31
*   ✒️Apache 2.4.46
*   ⛕️Git 2.31.1.windows.1
*   🌿 Twig 3

### Code quality

Codacy : [![Codacy Badge](https://app.codacy.com/project/badge/Grade/153bb5c6689941348cc9307be6cdccf3)](https://www.codacy.com/gh/Drx85/phv_res_module/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Drx85/phv_res_module&amp;utm_campaign=Badge_Grade)

Code Climate : [![Maintainability](https://api.codeclimate.com/v1/badges/753a27d9f346c2720b37/maintainability)](https://codeclimate.com/github/Drx85/phv_res_module/maintainability)

## Getting Started

To get a copy up and running follow these simple steps.

### PREREQUISITES

### Server

*   PHP > 8.0.9
*   Hosting provider or XAMPP/WAMP for local use
*   MySQL DMBS like [phpMyAdmin](https://docs.phpmyadmin.net/fr/latest/setup.html)

### Framework and libraries

*   Symfony > 5.3.7
*   Libraries will be installed using Composer
*   CSS libraries are directly called via CDN (Tailwind CSS)

### APIs

*   Google API : You will need an API key : Register on [Google Maps Platform](https://mapsplatform.google.com/) (you can have a free period). Then, follow [these steps](https://developers.google.com/maps/gmp-get-started?hl=fr#api-key) to get your own key. You will have to activate these APIs : Directions API, Maps Javascript API, Places API.
*   Paypal API : Follow [these steps](https://developer.paypal.com/docs/api/overview/) to get your credentials (Client ID & Client Secret). To simulate the payment, you can use [Sandbox accounts](https://developer.paypal.com/developer/accounts/).

### INSTALLATION

### Clone / Download

1.  Git clone the repository from this page. **See** [GitHub Documentation](https://docs.github.com/en/github/creating-cloning-and-archiving-repositories/cloning-a-repository-from-github/cloning-a-repository)

### Config

1.  Open ***.env.example*** file, then replace Database, prices and API credentials fields with your own information, and rename it ***.env***
2.  If you are missing Database information, please ask you webhost for it

### Install all dependencies
1.  Install Composer if you don't have it yet. **See** [Composer Documentation](https://getcomposer.org/download/)
2.  In your CMD, move on your project directory using cd command :
```sh
cd your/directory
```

3.  Run :
```sh
composer install
```
All dependencies should be installed in a vendor directory.

### Database

1.  Create new Database in your favorite MySQL DMBS running
```sh
php bin/console doctrine:database:create
```

2.  Import database tables running
```sh
php bin/console doctrine:migrations:migrate
```

### Server (local only)

1.  To start the server, run
```sh
symfony s:start
```
## Usage

### Online example version

Please see an hosted example version here : [https://deperne.fr/phv_res_module/public/](https://deperne.fr/phv_res_module/public/)

## Contact

Cédric Deperne - [cedric@deperne.fr](mailto:cedric@deperne.fr)

[Project Link](https://github.com/Drx85/phv_res_module)
