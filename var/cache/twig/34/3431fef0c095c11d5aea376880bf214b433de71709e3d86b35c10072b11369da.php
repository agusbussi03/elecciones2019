<?php

/* filtrosgobernador.html.twig */
class __TwigTemplate_e83c0ce7ae8f8c312ecad683437d7893e9c53732cb8177c433a73b1a02b9b7a1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "filtrosgobernador.html.twig", 1);
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
        $__internal_6113094afe4827519681f121cebe65031e15b858fc6c696c156ebe5d430ab255 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_6113094afe4827519681f121cebe65031e15b858fc6c696c156ebe5d430ab255->enter($__internal_6113094afe4827519681f121cebe65031e15b858fc6c696c156ebe5d430ab255_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "filtrosgobernador.html.twig"));

        $__internal_b36e633ab80ced145782d71fb8c0c9ba76a5196707a3b5150707f26fd5d4b8a5 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_b36e633ab80ced145782d71fb8c0c9ba76a5196707a3b5150707f26fd5d4b8a5->enter($__internal_b36e633ab80ced145782d71fb8c0c9ba76a5196707a3b5150707f26fd5d4b8a5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "filtrosgobernador.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_6113094afe4827519681f121cebe65031e15b858fc6c696c156ebe5d430ab255->leave($__internal_6113094afe4827519681f121cebe65031e15b858fc6c696c156ebe5d430ab255_prof);

        
        $__internal_b36e633ab80ced145782d71fb8c0c9ba76a5196707a3b5150707f26fd5d4b8a5->leave($__internal_b36e633ab80ced145782d71fb8c0c9ba76a5196707a3b5150707f26fd5d4b8a5_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_ed90dc63616cc1cf67b585bc1919b1680b4e01ade87e069c5f245ebae5d703df = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ed90dc63616cc1cf67b585bc1919b1680b4e01ade87e069c5f245ebae5d703df->enter($__internal_ed90dc63616cc1cf67b585bc1919b1680b4e01ade87e069c5f245ebae5d703df_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        $__internal_a13f48f05adf7e4b21cda0b59d297cf6e4c497a1351ec5ab35d6d0460756fb27 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_a13f48f05adf7e4b21cda0b59d297cf6e4c497a1351ec5ab35d6d0460756fb27->enter($__internal_a13f48f05adf7e4b21cda0b59d297cf6e4c497a1351ec5ab35d6d0460756fb27_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    ";
        $this->loadTemplate("navigator.html.twig", "filtrosgobernador.html.twig", 4)->display($context);
        // line 5
        echo "    <div id=\"page-wrapper\">
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <h1 class=\"page-header\">Filtros Gobernador</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <div class=\"panel panel-default\">

                    <div class=\"panel-heading\">
                        Filtros a nivel general para gobernador
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
        echo "                        <form action=\"filtrosgobernador\" method=\"POST\">
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
        
        $__internal_a13f48f05adf7e4b21cda0b59d297cf6e4c497a1351ec5ab35d6d0460756fb27->leave($__internal_a13f48f05adf7e4b21cda0b59d297cf6e4c497a1351ec5ab35d6d0460756fb27_prof);

        
        $__internal_ed90dc63616cc1cf67b585bc1919b1680b4e01ade87e069c5f245ebae5d703df->leave($__internal_ed90dc63616cc1cf67b585bc1919b1680b4e01ade87e069c5f245ebae5d703df_prof);

    }

    // line 70
    public function block_final($context, array $blocks = array())
    {
        $__internal_151dc1944f95ef2285d16d9f1248275b08f3c5220ff66acd9e11b19899ea84a2 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_151dc1944f95ef2285d16d9f1248275b08f3c5220ff66acd9e11b19899ea84a2->enter($__internal_151dc1944f95ef2285d16d9f1248275b08f3c5220ff66acd9e11b19899ea84a2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "final"));

        $__internal_dc0d23d1208cbe1e13028ef56decf59c32657253878880b8d8df08be12dfee10 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_dc0d23d1208cbe1e13028ef56decf59c32657253878880b8d8df08be12dfee10->enter($__internal_dc0d23d1208cbe1e13028ef56decf59c32657253878880b8d8df08be12dfee10_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "final"));

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
        
        $__internal_dc0d23d1208cbe1e13028ef56decf59c32657253878880b8d8df08be12dfee10->leave($__internal_dc0d23d1208cbe1e13028ef56decf59c32657253878880b8d8df08be12dfee10_prof);

        
        $__internal_151dc1944f95ef2285d16d9f1248275b08f3c5220ff66acd9e11b19899ea84a2->leave($__internal_151dc1944f95ef2285d16d9f1248275b08f3c5220ff66acd9e11b19899ea84a2_prof);

    }

    public function getTemplateName()
    {
        return "filtrosgobernador.html.twig";
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
                <h1 class=\"page-header\">Filtros Gobernador</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <div class=\"panel panel-default\">

                    <div class=\"panel-heading\">
                        Filtros a nivel general para gobernador
                    </div>
                    <!-- /.panel-heading -->
                    <div class=\"panel-body\">
                        {% if mensaje %}
                        <div class=\"alert alert-success alert-dismissable\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                            {{mensaje}} 
                        </div>
                        {% endif %}
                        <form action=\"filtrosgobernador\" method=\"POST\">
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


", "filtrosgobernador.html.twig", "/var/www/elecciones/templates/filtrosgobernador.html.twig");
    }
}
