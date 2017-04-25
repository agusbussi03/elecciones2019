<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_16241a6ad7f432c311dabc434a9bdff388a31ed231421bd45419c44878872555 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/router.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_5be0a885c4e71deae3eb76a179f90bcb8f1dfc4d66d1899e9c80aaae06548e9c = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_5be0a885c4e71deae3eb76a179f90bcb8f1dfc4d66d1899e9c80aaae06548e9c->enter($__internal_5be0a885c4e71deae3eb76a179f90bcb8f1dfc4d66d1899e9c80aaae06548e9c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $__internal_0d5a06fc25dbb792848a11177869feb2eefeeaf8ddcd4f4151931b3e9973060f = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_0d5a06fc25dbb792848a11177869feb2eefeeaf8ddcd4f4151931b3e9973060f->enter($__internal_0d5a06fc25dbb792848a11177869feb2eefeeaf8ddcd4f4151931b3e9973060f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_5be0a885c4e71deae3eb76a179f90bcb8f1dfc4d66d1899e9c80aaae06548e9c->leave($__internal_5be0a885c4e71deae3eb76a179f90bcb8f1dfc4d66d1899e9c80aaae06548e9c_prof);

        
        $__internal_0d5a06fc25dbb792848a11177869feb2eefeeaf8ddcd4f4151931b3e9973060f->leave($__internal_0d5a06fc25dbb792848a11177869feb2eefeeaf8ddcd4f4151931b3e9973060f_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_153c0f2c24641001c96f3154f08ca19f72f06f821b2d4528a109e928793f18b2 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_153c0f2c24641001c96f3154f08ca19f72f06f821b2d4528a109e928793f18b2->enter($__internal_153c0f2c24641001c96f3154f08ca19f72f06f821b2d4528a109e928793f18b2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        $__internal_e52090f307caa6b283b3c1706546d15099e61a8f7a8d21a8e4c673ab456a3f0a = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_e52090f307caa6b283b3c1706546d15099e61a8f7a8d21a8e4c673ab456a3f0a->enter($__internal_e52090f307caa6b283b3c1706546d15099e61a8f7a8d21a8e4c673ab456a3f0a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_e52090f307caa6b283b3c1706546d15099e61a8f7a8d21a8e4c673ab456a3f0a->leave($__internal_e52090f307caa6b283b3c1706546d15099e61a8f7a8d21a8e4c673ab456a3f0a_prof);

        
        $__internal_153c0f2c24641001c96f3154f08ca19f72f06f821b2d4528a109e928793f18b2->leave($__internal_153c0f2c24641001c96f3154f08ca19f72f06f821b2d4528a109e928793f18b2_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_6b2fc74604a8d4271bedb62e3ebd20cc1104533e1b5ab94caf0c852e09e073df = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_6b2fc74604a8d4271bedb62e3ebd20cc1104533e1b5ab94caf0c852e09e073df->enter($__internal_6b2fc74604a8d4271bedb62e3ebd20cc1104533e1b5ab94caf0c852e09e073df_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        $__internal_eebbfe4c457fe44a2a6de4fc6369e0ed20ccdc6fe1318bc012aa4dc57ba3329b = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_eebbfe4c457fe44a2a6de4fc6369e0ed20ccdc6fe1318bc012aa4dc57ba3329b->enter($__internal_eebbfe4c457fe44a2a6de4fc6369e0ed20ccdc6fe1318bc012aa4dc57ba3329b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_eebbfe4c457fe44a2a6de4fc6369e0ed20ccdc6fe1318bc012aa4dc57ba3329b->leave($__internal_eebbfe4c457fe44a2a6de4fc6369e0ed20ccdc6fe1318bc012aa4dc57ba3329b_prof);

        
        $__internal_6b2fc74604a8d4271bedb62e3ebd20cc1104533e1b5ab94caf0c852e09e073df->leave($__internal_6b2fc74604a8d4271bedb62e3ebd20cc1104533e1b5ab94caf0c852e09e073df_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_3b4121a9f51c940dceb403ae0d679a0d0925ec7acff29125f8c4f1e5f43bf8f9 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_3b4121a9f51c940dceb403ae0d679a0d0925ec7acff29125f8c4f1e5f43bf8f9->enter($__internal_3b4121a9f51c940dceb403ae0d679a0d0925ec7acff29125f8c4f1e5f43bf8f9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        $__internal_56fbfb4bdf08e753b1d4ed02e63469c9520088da47cfbe0a68ba10aec29d6426 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_56fbfb4bdf08e753b1d4ed02e63469c9520088da47cfbe0a68ba10aec29d6426->enter($__internal_56fbfb4bdf08e753b1d4ed02e63469c9520088da47cfbe0a68ba10aec29d6426_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getRuntime('Symfony\Bridge\Twig\Extension\HttpKernelRuntime')->renderFragment($this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("_profiler_router", array("token" => (isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new Twig_Error_Runtime('Variable "token" does not exist.', 13, $this->getSourceContext()); })()))));
        echo "
";
        
        $__internal_56fbfb4bdf08e753b1d4ed02e63469c9520088da47cfbe0a68ba10aec29d6426->leave($__internal_56fbfb4bdf08e753b1d4ed02e63469c9520088da47cfbe0a68ba10aec29d6426_prof);

        
        $__internal_3b4121a9f51c940dceb403ae0d679a0d0925ec7acff29125f8c4f1e5f43bf8f9->leave($__internal_3b4121a9f51c940dceb403ae0d679a0d0925ec7acff29125f8c4f1e5f43bf8f9_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/router.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  94 => 13,  85 => 12,  71 => 7,  68 => 6,  59 => 5,  42 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@WebProfiler/Profiler/layout.html.twig' %}

{% block toolbar %}{% endblock %}

{% block menu %}
<span class=\"label\">
    <span class=\"icon\">{{ include('@WebProfiler/Icon/router.svg') }}</span>
    <strong>Routing</strong>
</span>
{% endblock %}

{% block panel %}
    {{ render(path('_profiler_router', { token: token })) }}
{% endblock %}
", "@WebProfiler/Collector/router.html.twig", "/var/www/elecciones/vendor/symfony/web-profiler-bundle/Resources/views/Collector/router.html.twig");
    }
}
