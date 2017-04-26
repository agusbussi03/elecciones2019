<?php

/* filtrossenador.html.twig */
class __TwigTemplate_339eda3d639d8e374a7e34c3985e6f4def1a50a2043d3dd17d52e200ec9fc6b6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "filtrossenador.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'final' => array($this, 'block_final'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_6712919a5f03da9913550aa998c861c5dfffb4dc44e36adce917856b29f9da3c = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_6712919a5f03da9913550aa998c861c5dfffb4dc44e36adce917856b29f9da3c->enter($__internal_6712919a5f03da9913550aa998c861c5dfffb4dc44e36adce917856b29f9da3c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "filtrossenador.html.twig"));

        $__internal_02d815436617a5e606f6e038ea12cc76a5a47dd834b347a5fed500b2055d630f = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_02d815436617a5e606f6e038ea12cc76a5a47dd834b347a5fed500b2055d630f->enter($__internal_02d815436617a5e606f6e038ea12cc76a5a47dd834b347a5fed500b2055d630f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "filtrossenador.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_6712919a5f03da9913550aa998c861c5dfffb4dc44e36adce917856b29f9da3c->leave($__internal_6712919a5f03da9913550aa998c861c5dfffb4dc44e36adce917856b29f9da3c_prof);

        
        $__internal_02d815436617a5e606f6e038ea12cc76a5a47dd834b347a5fed500b2055d630f->leave($__internal_02d815436617a5e606f6e038ea12cc76a5a47dd834b347a5fed500b2055d630f_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_88be76c564925f9ea92596364966f0602f92d19ca7781c5f3558389ab0bf1247 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_88be76c564925f9ea92596364966f0602f92d19ca7781c5f3558389ab0bf1247->enter($__internal_88be76c564925f9ea92596364966f0602f92d19ca7781c5f3558389ab0bf1247_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        $__internal_bbcf5c379c345951ea12058dc14e74e69ce79e142ae51e2b4e055b0a5cfce57d = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_bbcf5c379c345951ea12058dc14e74e69ce79e142ae51e2b4e055b0a5cfce57d->enter($__internal_bbcf5c379c345951ea12058dc14e74e69ce79e142ae51e2b4e055b0a5cfce57d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    ";
        $this->loadTemplate("navigator.html.twig", "filtrossenador.html.twig", 4)->display($context);
        // line 5
        echo "    <div id=\"page-wrapper\">
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <h1 class=\"page-header\">Filtros Senador</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <div class=\"panel panel-default\">

                    <div class=\"panel-heading\">
                        Filtros a nivel departamental para senador
                    </div>
                    <!-- /.panel-heading -->
                    <div class=\"panel-body\">
                        ";
        // line 22
        if ((isset($context["mensaje"]) || array_key_exists("mensaje", $context) ? $context["mensaje"] : (function () { throw new Twig_Error_Runtime('Variable "mensaje" does not exist.', 22, $this->getSourceContext()); })())) {
            // line 23
            echo "                        <div class=\"alert alert-success alert-dismissable\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                            ";
            // line 25
            echo twig_escape_filter($this->env, (isset($context["mensaje"]) || array_key_exists("mensaje", $context) ? $context["mensaje"] : (function () { throw new Twig_Error_Runtime('Variable "mensaje" does not exist.', 25, $this->getSourceContext()); })()), "html", null, true);
            echo " 
                        </div>
                        ";
        }
        // line 28
        echo "                        <form action=\"filtrossenador\" method=\"POST\">
                            <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" >
                                <thead>
                                    <tr>
                                        <th>Partido</th>
                                        <th>Lista</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
        // line 38
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["disponibles"]) || array_key_exists("disponibles", $context) ? $context["disponibles"] : (function () { throw new Twig_Error_Runtime('Variable "disponibles" does not exist.', 38, $this->getSourceContext()); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 39
            echo "                                        <tr class=\"odd gradeX\">
                                            <td>";
            // line 40
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "pspar", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "parnombre", array()), "html", null, true);
            echo "</td>
                                            <td>";
            // line 41
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "pslista", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "nombre", array()), "html", null, true);
            echo "</td>
                                            <td><input type=\"checkbox\" name=\"";
            // line 42
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "pspar", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "pslista", array()), "html", null, true);
            echo "\" class=\"btn btn-primary\"
                                                       ";
            // line 43
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["filtros"]) || array_key_exists("filtros", $context) ? $context["filtros"] : (function () { throw new Twig_Error_Runtime('Variable "filtros" does not exist.', 43, $this->getSourceContext()); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["filtro"]) {
                // line 44
                echo "                                                           ";
                if (((twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "pspar", array()) == twig_get_attribute($this->env, $this->getSourceContext(), $context["filtro"], "pspar", array())) && (twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "pslista", array()) == twig_get_attribute($this->env, $this->getSourceContext(), $context["filtro"], "pslista", array())))) {
                    echo "checked";
                }
                // line 45
                echo "                                                       ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['filtro'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            echo "></td>
                                        </tr>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 48
        echo "
                                </tbody>
                            </table>
                            <input type=\"submit\" value=\"Grabar\" class=\"btn btn-primary\">
                        </form>
                        <!-- /.table-responsive -->

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#wrapper -->



";
        
        $__internal_bbcf5c379c345951ea12058dc14e74e69ce79e142ae51e2b4e055b0a5cfce57d->leave($__internal_bbcf5c379c345951ea12058dc14e74e69ce79e142ae51e2b4e055b0a5cfce57d_prof);

        
        $__internal_88be76c564925f9ea92596364966f0602f92d19ca7781c5f3558389ab0bf1247->leave($__internal_88be76c564925f9ea92596364966f0602f92d19ca7781c5f3558389ab0bf1247_prof);

    }

    // line 70
    public function block_final($context, array $blocks = array())
    {
        $__internal_3e62d85436b0cd74f1414046d749ab2cfa53c99facb3e8baf38b19aaeb81adc2 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_3e62d85436b0cd74f1414046d749ab2cfa53c99facb3e8baf38b19aaeb81adc2->enter($__internal_3e62d85436b0cd74f1414046d749ab2cfa53c99facb3e8baf38b19aaeb81adc2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "final"));

        $__internal_baa971aca2d36e7581c701daec65cc1c2822e1ef0eed89cdac06227c1ae77c3a = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_baa971aca2d36e7581c701daec65cc1c2822e1ef0eed89cdac06227c1ae77c3a->enter($__internal_baa971aca2d36e7581c701daec65cc1c2822e1ef0eed89cdac06227c1ae77c3a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "final"));

        // line 71
        echo "    <!-- DataTables JavaScript -->
    <script src=\"";
        // line 72
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("/vendor/datatables/js/jquery.dataTables.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 73
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("/vendor/datatables-plugins/dataTables.bootstrap.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 74
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/datatables-responsive/dataTables.responsive.js"), "html", null, true);
        echo "\"></script>



";
        
        $__internal_baa971aca2d36e7581c701daec65cc1c2822e1ef0eed89cdac06227c1ae77c3a->leave($__internal_baa971aca2d36e7581c701daec65cc1c2822e1ef0eed89cdac06227c1ae77c3a_prof);

        
        $__internal_3e62d85436b0cd74f1414046d749ab2cfa53c99facb3e8baf38b19aaeb81adc2->leave($__internal_3e62d85436b0cd74f1414046d749ab2cfa53c99facb3e8baf38b19aaeb81adc2_prof);

    }

    public function getTemplateName()
    {
        return "filtrossenador.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  193 => 74,  189 => 73,  185 => 72,  182 => 71,  173 => 70,  143 => 48,  130 => 45,  125 => 44,  121 => 43,  115 => 42,  109 => 41,  103 => 40,  100 => 39,  96 => 38,  84 => 28,  78 => 25,  74 => 23,  72 => 22,  53 => 5,  50 => 4,  41 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"layout.html.twig\" %}

{% block content %}
    {% include \"navigator.html.twig\" %}
    <div id=\"page-wrapper\">
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <h1 class=\"page-header\">Filtros Senador</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <div class=\"panel panel-default\">

                    <div class=\"panel-heading\">
                        Filtros a nivel departamental para senador
                    </div>
                    <!-- /.panel-heading -->
                    <div class=\"panel-body\">
                        {% if mensaje %}
                        <div class=\"alert alert-success alert-dismissable\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                            {{mensaje}} 
                        </div>
                        {% endif %}
                        <form action=\"filtrossenador\" method=\"POST\">
                            <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" >
                                <thead>
                                    <tr>
                                        <th>Partido</th>
                                        <th>Lista</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for item in disponibles %}
                                        <tr class=\"odd gradeX\">
                                            <td>{{item.pspar}}-{{item.parnombre}}</td>
                                            <td>{{item.pslista}}-{{item.nombre}}</td>
                                            <td><input type=\"checkbox\" name=\"{{item.pspar}}-{{item.pslista}}\" class=\"btn btn-primary\"
                                                       {% for filtro in filtros %}
                                                           {% if item.pspar==filtro.pspar and item.pslista==filtro.pslista%}checked{% endif %}
                                                       {% endfor %}></td>
                                        </tr>
                                    {% endfor %}

                                </tbody>
                            </table>
                            <input type=\"submit\" value=\"Grabar\" class=\"btn btn-primary\">
                        </form>
                        <!-- /.table-responsive -->

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#wrapper -->



{% endblock %}    

{% block final %}
    <!-- DataTables JavaScript -->
    <script src=\"{{ asset('/vendor/datatables/js/jquery.dataTables.min.js') }}\"></script>
    <script src=\"{{ asset('/vendor/datatables-plugins/dataTables.bootstrap.min.js') }}\"></script>
    <script src=\"{{ asset('vendor/datatables-responsive/dataTables.responsive.js') }}\"></script>



{% endblock %}


", "filtrossenador.html.twig", "/var/www/elecciones/templates/filtrossenador.html.twig");
    }
}
