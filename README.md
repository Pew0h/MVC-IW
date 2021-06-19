# MVC - Router avec paramètres GET dynamique
### Routes
Listes des méthodes (RequestMethod.php)
  - GET
  - POST
  - DELETE
  - PUT
 
### Exemple d'une route sans paramètre
```php
$router->addPath(
  '/index',
  RequestMethod::GET,
  'home2',
  HomeController::class,
  'index'
);
```

### Exemple d'une routeavec paramètre dynamique
```php
$router->addPath(
  '/contact/edit/{id}/{name}',
  RequestMethod::GET,
  'contact',
  HomeController::class,
  'contact'
);
```

Pour obtenir la valeur des paramètre dynamique, vous devez faire appel aux paramètres dans les attributs de votre méthode du Controller.

Exemple dans HomeController.php:
```php
public function contact(EntityManager $em, $id, $name)
  {
    echo $this->twig->render('contact.html.twig', ['id' => $id, 'name' => $name]);
  }
```

Pour finir, pour afficher la valeur dans votre vue vous avez juste à faire appel au nom que vous avez déterminé :
```twig
Valeur ID: {{ id }}
Valeur name: {{ name }}
```