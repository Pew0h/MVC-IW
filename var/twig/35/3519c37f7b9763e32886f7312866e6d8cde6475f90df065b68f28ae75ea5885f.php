<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* contact.html.twig */
class __TwigTemplate_442dcb514dd142cce14198b252a31f422d2855db0a66d2f92333d6660226f8c7 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.html.twig", "contact.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 2
        echo "<h1>Contact</h1>
<form action=\"\">
  <label for=\"name\">Nom : </label>
  <input type=\"text\" name=\"name\" id=\"name\" />
  <label for=\"message\">Message :</label>
  <textarea name=\"message\" id=\"message\" cols=\"30\" rows=\"10\"></textarea>
  <button type=\"submit\">Envoyer</button>
</form>
Valeur ID: ";
        // line 10
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "
<br>
Valeur name: ";
        // line 12
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo "
";
    }

    public function getTemplateName()
    {
        return "contact.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  64 => 12,  59 => 10,  49 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %} {% block body %}
<h1>Contact</h1>
<form action=\"\">
  <label for=\"name\">Nom : </label>
  <input type=\"text\" name=\"name\" id=\"name\" />
  <label for=\"message\">Message :</label>
  <textarea name=\"message\" id=\"message\" cols=\"30\" rows=\"10\"></textarea>
  <button type=\"submit\">Envoyer</button>
</form>
Valeur ID: {{ id }}
<br>
Valeur name: {{ name }}
{% endblock %}

", "contact.html.twig", "C:\\Users\\burl4\\Desktop\\ESGI - cours\\PHP - MVC\\Semestre 2\\MVC\\templates\\contact.html.twig");
    }
}
