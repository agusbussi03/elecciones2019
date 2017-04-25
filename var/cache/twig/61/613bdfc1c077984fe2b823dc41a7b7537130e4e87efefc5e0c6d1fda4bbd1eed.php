<?php

/* @WebProfiler/Collector/ajax.html.twig */
class __TwigTemplate_ce6597c888930383087a77f79f72a0032d60146a12c1b1b91347e0c9eb2e327a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/ajax.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_3d15b3712ca677ed48e63524f1072820963ee29ee71bed4cc7c8a14ec53c97b4 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_3d15b3712ca677ed48e63524f1072820963ee29ee71bed4cc7c8a14ec53c97b4->enter($__internal_3d15b3712ca677ed48e63524f1072820963ee29ee71bed4cc7c8a14ec53c97b4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/ajax.html.twig"));

        $__internal_7e35a56dd5c5c978e61d549689e117971d06f6d07bb4ffd3dac747cd4c467719 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_7e35a56dd5c5c978e61d549689e117971d06f6d07bb4ffd3dac747cd4c467719->enter($__internal_7e35a56dd5c5c978e61d549689e117971d06f6d07bb4ffd3dac747cd4c467719_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/ajax.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_3d15b3712ca677ed48e63524f1072820963ee29ee71bed4cc7c8a14ec53c97b4->leave($__internal_3d15b3712ca677ed48e63524f1072820963ee29ee71bed4cc7c8a14ec53c97b4_prof);

        
        $__internal_7e35a56dd5c5c978e61d549689e117971d06f6d07bb4ffd3dac747cd4c467719->leave($__internal_7e35a56dd5c5c978e61d549689e117971d06f6d07bb4ffd3dac747cd4c467719_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_1909cbfbb911e6bf2dce12950c51e1e0244f2838e6e87c8e25225851655f1f76 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_1909cbfbb911e6bf2dce12950c51e1e0244f2838e6e87c8e25225851655f1f76->enter($__internal_1909cbfbb911e6bf2dce12950c51e1e0244f2838e6e87c8e25225851655f1f76_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        $__internal_b1d424b3e39a9f17b528aceb31f04766bf5e84ac1f635b77b125ff3dfac25e8d = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_b1d424b3e39a9f17b528aceb31f04766bf5e84ac1f635b77b125ff3dfac25e8d->enter($__internal_b1d424b3e39a9f17b528aceb31f04766bf5e84ac1f635b77b125ff3dfac25e8d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        // line 4
        echo "    ";
        ob_start();
        // line 5
        echo "        ";
        echo twig_include($this->env, $context, "@WebProfiler/Icon/ajax.svg");
        echo "
        <span class=\"sf-toolbar-value sf-toolbar-ajax-requests\">0</span>
    ";
        $context["icon"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 8
        echo "
    ";
        // line 9
        $context["text"] = ('' === $tmp = "        <div class=\"sf-toolbar-info-piece\">
            <b class=\"sf-toolbar-ajax-info\"></b>
        </div>
        <div class=\"sf-toolbar-info-piece\">
            <table class=\"sf-toolbar-ajax-requests\">
                <thead>
                    <tr>
                        <th>Method</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>URL</th>
                        <th>Time</th>
                        <th>Profile</th>
                    </tr>
                </thead>
                <tbody class=\"sf-toolbar-ajax-request-list\"></tbody>
            </table>
        </div>
    ") ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 29
        echo "
    ";
        // line 30
        echo twig_include($this->env, $context, "@WebProfiler/Profiler/toolbar_item.html.twig", array("link" => false));
        echo "
";
        
        $__internal_b1d424b3e39a9f17b528aceb31f04766bf5e84ac1f635b77b125ff3dfac25e8d->leave($__internal_b1d424b3e39a9f17b528aceb31f04766bf5e84ac1f635b77b125ff3dfac25e8d_prof);

        
        $__internal_1909cbfbb911e6bf2dce12950c51e1e0244f2838e6e87c8e25225851655f1f76->leave($__internal_1909cbfbb911e6bf2dce12950c51e1e0244f2838e6e87c8e25225851655f1f76_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/ajax.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  85 => 30,  82 => 29,  62 => 9,  59 => 8,  52 => 5,  49 => 4,  40 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@WebProfiler/Profiler/layout.html.twig' %}

{% block toolbar %}
    {% set icon %}
        {{ include('@WebProfiler/Icon/ajax.svg') }}
        <span class=\"sf-toolbar-value sf-toolbar-ajax-requests\">0</span>
    {% endset %}

    {% set text %}
        <div class=\"sf-toolbar-info-piece\">
            <b class=\"sf-toolbar-ajax-info\"></b>
        </div>
        <div class=\"sf-toolbar-info-piece\">
            <table class=\"sf-toolbar-ajax-requests\">
                <thead>
                    <tr>
                        <th>Method</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>URL</th>
                        <th>Time</th>
                        <th>Profile</th>
                    </tr>
                </thead>
                <tbody class=\"sf-toolbar-ajax-request-list\"></tbody>
            </table>
        </div>
    {% endset %}

    {{ include('@WebProfiler/Profiler/toolbar_item.html.twig', { link: false }) }}
{% endblock %}
", "@WebProfiler/Collector/ajax.html.twig", "/var/www/elecciones/vendor/symfony/web-profiler-bundle/Resources/views/Collector/ajax.html.twig");
    }
}
