<?php

namespace App;

use App\Controller\RequestMethod;
use Doctrine\DBAL\Types\VarDateTimeType;
use Doctrine\ORM\EntityManager;
use ReflectionMethod;
use Twig\Environment;

class Router
{
  private $paths = [];
  // Paramètres injectables dans les méthodes de contrôleurs
  private $params = [];
  private $twigInstance;

  public function __construct(EntityManager $em, Environment $twig)
  {
    $this->params[EntityManager::class] = $em;
    $this->twigInstance = $twig;
  }

  public function addPath(string $path, string $httpMethod, string $name, string $class, string $method)
  {
    $this->paths[] = ([
      'path' => $path,
      'http_method' => $httpMethod,
      'name' => $name,
      'class' => $class,
      'method' => $method
    ]);
 
  }

  public function execute(string $requestPath, string $requestMethod)
  {
    if ($path = $this->checkPath($requestPath, $requestMethod)) {
      // Récupération nom de la classe et nom de la méthode
      $className = $path['class'];
      $methodName = $path['method'];


      // Initialisation des paramètres qui vont être injectés
      // Par défaut : aucun, donc tableau vide
      $params = [];

      // Récupération des infos de la méthode avec Reflection
      $methodInfos = new ReflectionMethod($className . '::' . $methodName);
      // Récupération des paramètres de la méthode
      $parameters = $methodInfos->getParameters();


      // Analyse des différents paramètres
      // Du coup, pas de boucle si pas de paramètre
      foreach ($parameters as $param) {
        $paramName = $param->getName();
        $typeName = $param->getType() ? $param->getType()->getName() : $paramName; // si aucun type défini, considéré comme un atribut de l'url
        //var_dump($paramName);
        // Vérification si le nom du paramètre existe dans les paramètres injectables
        if (array_key_exists($typeName, $this->params)) {
          // Enregistrement du paramètre dans les paramètres à injecter
          $params[$paramName] = $this->params[$typeName];
        }
      }

  
      // Instanciation du contrôleur
      $controller = new $className($this->twigInstance);

      // Appel de la méthode adéquate, avec le(s) paramètre(s) adéquat(s), ou aucun paramètre
      call_user_func_array(
        [$controller, $methodName],
        $params
      );
    } else {
      http_response_code(404);
    }
  }

  public function checkPath(string $requestPath, string $requestMethod)
  {
    foreach ($this->paths as $path) {
      $Pregpath = preg_replace('#({[\w]+})#', '([^/]+)', $path['path']);
      preg_match('#\{.+}#', $path['path'], $pathParameters); // obtenir les différent nom des paramètres

      foreach($pathParameters as $parameter)
      {
        $pathParameters = explode('/', $parameter); // Mettre chaque paramètres dans un tableau et enlevant le "/" car sinon nous aurons par ex: {id}/{name}
        // Enlève les {} pour obtenir les noms des paramètres en clair
        $pathParameters = str_replace('{', '', $pathParameters);
        $pathParameters = str_replace('}', '', $pathParameters);
      }

      $PathToMatch = "#^$Pregpath$#";

      if(preg_match($PathToMatch, $requestPath, $matches) && $path['http_method'] == $requestMethod) // Si URL = PATH + même méthode
      {
        array_shift($matches); // Suppression du premier index qui équivaut à l'URL
        if(isset($matches)) 
        {
          // Pour chaque paramètres dynamique du path, on récupère sa valeur et on l'injecte dans la variables des paramètres à injecter
          for($i = 0; $i < count($pathParameters); $i++)
          {
            $this->params[$pathParameters[$i]] = $matches[$i];// ex : 'id' => '4'
          }
          return $path;
        }
      }
    }
  }
}
