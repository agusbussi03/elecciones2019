<?php

/* @WebProfiler/Collector/exception.html.twig */
class __TwigTemplate_0bda99fe8c03b6fe8d168683df504fdafb0792640ea6f06ad187c5fc86f56c40 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/exception.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
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
        $__internal_81e3759cb36a94ff3a2e3e70f5e13553722e95e1a64f7a16dc045136b244956c = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_81e3759cb36a94ff3a2e3e70f5e13553722e95e1a64f7a16dc045136b244956c->enter($__internal_81e3759cb36a94ff3a2e3e70f5e13553722e95e1a64f7a16dc045136b244956c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/exception.html.twig"));

        $__internal_062170fc5e35079fdef55f7a38cc8ddac5b12964bd5ec8ea5944b50071c21327 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_062170fc5e35079fdef55f7a38cc8ddac5b12964bd5ec8ea5944b50071c21327->enter($__internal_062170fc5e35079fdef55f7a38cc8ddac5b12964bd5ec8ea5944b50071c21327_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/exception.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_81e3759cb36a94ff3a2e3e70f5e13553722e95e1a64f7a16dc045136b244956c->leave($__internal_81e3759cb36a94ff3a2e3e70f5e13553722e95e1a64f7a16dc045136b244956c_prof);

        
        $__internal_062170fc5e35079fdef55f7a38cc8ddac5b12964bd5ec8ea5944b50071c21327->leave($__internal_062170fc5e35079fdef55f7a38cc8ddac5b12964bd5ec8ea5944b50071c21327_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_eb73caaa99410ef03fa9842344aafcdd44aa4a01e2f874f5356147627f3861ff = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_eb73caaa99410ef03fa9842344aafcdd44aa4a01e2f874f5356147627f3861ff->enter($__internal_eb73caaa99410ef03fa9842344aafcdd44aa4a01e2f874f5356147627f3861ff_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        $__internal_5fc73fe43340c1dd4afe172f3cf9fa196970425ca46cd4cfb62e3659cf0bf55e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_5fc73fe43340c1dd4afe172f3cf9fa196970425ca46cd4cfb62e3659cf0bf55e->enter($__internal_5fc73fe43340c1dd4afe172f3cf9fa196970425ca46cd4cfb62e3659cf0bf55e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    ";
        if (twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new Twig_Error_Runtime('Variable "collector" does not exist.', 4, $this->getSourceContext()); })()), "hasexception", array())) {
            // line 5
            echo "        <style>
            ";
            // line 6
            echo $this->env->getRuntime('Symfony\Bridge\Twig\Extension\HttpKernelRuntime')->renderFragment($this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("_profiler_exception_css", array("token" => (isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new Twig_Error_Runtime('Variable "token" does not exist.', 6, $this->getSourceContext()); })()))));
            echo "
        </style>
    ";
        }
        // line 9
        echo "    ";
        $this->displayParentBlock("head", $context, $blocks);
        echo "
";
        
        $__internal_5fc73fe43340c1dd4afe172f3cf9fa196970425ca46cd4cfb62e3659cf0bf55e->leave($__internal_5fc73fe43340c1dd4afe172f3cf9fa196970425ca46cd4cfb62e3659cf0bf55e_prof);

        
        $__internal_eb73caaa99410ef03fa9842344aafcdd44aa4a01e2f874f5356147627f3861ff->leave($__internal_eb73caaa99410ef03fa9842344aafcdd44aa4a01e2f874f5356147627f3861ff_prof);

    }

    // line 12
    public function block_menu($context, array $blocks = array())
    {
        $__internal_60e8139ce80f2d7124e241f088077b2a6f361ef2c730a8040489e1a9ca72527a = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_60e8139ce80f2d7124e241f088077b2a6f361ef2c730a8040489e1a9ca72527a->enter($__internal_60e8139ce80f2d7124e241f088077b2a6f361ef2c730a8040489e1a9ca72527a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        $__internal_42762357ea927032bb0d473d60f79b90474a66c0a935b03d22421a2f399fac98 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_42762357ea927032bb0d473d60f79b90474a66c0a935b03d22421a2f399fac98->enter($__internal_42762357ea927032bb0d473d60f79b90474a66c0a935b03d22421a2f399fac98_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 13
        echo "    <span class=\"label ";
        echo ((twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new Twig_Error_Runtime('Variable "collector" does not exist.', 13, $this->getSourceContext()); })()), "hasexception", array())) ? ("label-status-error") : ("disabled"));
        echo "\">
        <span class=\"icon\">";
        // line 14
        echo twig_include($this->env, $context, "@WebProfiler/Icon/exception.svg");
        echo "</span>
        <strong>Exception</strong>
        ";
        // line 16
        if (twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new Twig_Error_Runtime('Variable "collector" does not exist.', 16, $this->getSourceContext()); })()), "hasexception", array())) {
            // line 17
            echo "            <span class=\"count\">
                <span>1</span>
            </span>
        ";
        }
        // line 21
        echo "    </span>
";
        
        $__internal_42762357ea927032bb0d473d60f79b90474a66c0a935b03d22421a2f399fac98->leave($__internal_42762357ea927032bb0d473d60f79b90474a66c0a935b03d22421a2f399fac98_prof);

        
        $__internal_60e8139ce80f2d7124e241f088077b2a6f361ef2c730a8040489e1a9ca72527a->leave($__internal_60e8139ce80f2d7124e241f088077b2a6f361ef2c730a8040489e1a9ca72527a_prof);

    }

    // line 24
    public function block_panel($context, array $blocks = array())
    {
        $__internal_9bc471a2f013a239bd1daae77f262e245216b276dfacc516605f9ca806537746 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_9bc471a2f013a239bd1daae77f262e245216b276dfacc516605f9ca806537746->enter($__internal_9bc471a2f013a239bd1daae77f262e245216b276dfacc516605f9ca806537746_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        $__internal_1ec26eeb448baf8222891e3145ae7330120b122337e47c895be64f66e147ebcb = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_1ec26eeb448baf8222891e3145ae7330120b122337e47c895be64f66e147ebcb->enter($__internal_1ec26eeb448baf8222891e3145ae7330120b122337e47c895be64f66e147ebcb_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 25
        echo "    <h2>Exceptions</h2>

    ";
        // line 27
        if ( !twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new Twig_Error_Runtime('Variable "collector" does not exist.', 27, $this->getSourceContext()); })()), "hasexception", array())) {
            // line 28
            echo "        <div class=\"empty\">
            <p>No exception was thrown and caught during the request.</p>
        </div>
    ";
        } else {
            // line 32
            echo "        <div class=\"sf-reset\">
            ";
            // line 33
            echo $this->env->getRuntime('Symfony\Bridge\Twig\Extension\HttpKernelRuntime')->renderFragment($this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("_profiler_exception", array("token" => (isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new Twig_Error_Runtime('Variable "token" does not exist.', 33, $this->getSourceContext()); })()))));
            echo "
        </div>
    ";
        }
        
        $__internal_1ec26eeb448baf8222891e3145ae7330120b122337e47c895be64f66e147ebcb->leave($__internal_1ec26eeb448baf8222891e3145ae7330120b122337e47c895be64f66e147ebcb_prof);

        
        $__internal_9bc471a2f013a239bd1daae77f262e245216b276dfacc516605f9ca806537746->leave($__internal_9bc471a2f013a239bd1daae77f262e245216b276dfacc516605f9ca806537746_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/exception.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  138 => 33,  135 => 32,  129 => 28,  127 => 27,  123 => 25,  114 => 24,  103 => 21,  97 => 17,  95 => 16,  90 => 14,  85 => 13,  76 => 12,  63 => 9,  57 => 6,  54 => 5,  51 => 4,  42 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@WebProfiler/Profiler/layout.html.twig' %}

{% block head %}
    {% if collector.hasexception %}
        <style>
            {{ render(path('_profiler_exception_css', { token: token })) }}
        </style>
    {% endif %}
    {{ parent() }}
{% endblock %}

{% block menu %}
    <span class=\"label {{ collector.hasexception ? 'label-status-error' : 'disabled' }}\">
        <span class=\"icon\">{{ include('@WebProfiler/Icon/exception.svg') }}</span>
        <strong>Exception</strong>
        {% if collector.hasexception %}
            <span class=\"count\">
                <span>1</span>
            </span>
        {% endif %}
    </span>
{% endblock %}

{% block panel %}
    <h2>Exceptions</h2>

    {% if not collector.hasexception %}
        <div class=\"empty\">
            <p>No exception was thrown and caught during the request.</p>
        </div>
    {% else %}
        <div class=\"sf-reset\">
            {{ render(path('_profiler_exception', { token: token })) }}
        </div>
    {% endif %}
{% endblock %}
", "@WebProfiler/Collector/exception.html.twig", "/var/www/elecciones/vendor/symfony/web-profiler-bundle/Resources/views/Collector/exception.html.twig");
    }
}
