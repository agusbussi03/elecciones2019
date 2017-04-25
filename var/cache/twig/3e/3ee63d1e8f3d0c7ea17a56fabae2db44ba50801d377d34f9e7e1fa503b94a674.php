<?php

/* provincia.html.twig */
class __TwigTemplate_73533dcf914bf852a60220f2df57337f373212e236dc1871e97dba182972ecd2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "provincia.html.twig", 1);
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
        $__internal_0f2aeb14fb221659d6b8b904804d51ea30f2241e736202a97b9d60baba255f52 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0f2aeb14fb221659d6b8b904804d51ea30f2241e736202a97b9d60baba255f52->enter($__internal_0f2aeb14fb221659d6b8b904804d51ea30f2241e736202a97b9d60baba255f52_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "provincia.html.twig"));

        $__internal_f8406015f34a944a6805dea9c819b1a6591bd06a62f3e60dc91b8b070b9acf43 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_f8406015f34a944a6805dea9c819b1a6591bd06a62f3e60dc91b8b070b9acf43->enter($__internal_f8406015f34a944a6805dea9c819b1a6591bd06a62f3e60dc91b8b070b9acf43_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "provincia.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_0f2aeb14fb221659d6b8b904804d51ea30f2241e736202a97b9d60baba255f52->leave($__internal_0f2aeb14fb221659d6b8b904804d51ea30f2241e736202a97b9d60baba255f52_prof);

        
        $__internal_f8406015f34a944a6805dea9c819b1a6591bd06a62f3e60dc91b8b070b9acf43->leave($__internal_f8406015f34a944a6805dea9c819b1a6591bd06a62f3e60dc91b8b070b9acf43_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_8690a9d4303a89a4d8a7ababf3d2d8e2733ec8f69a5da24e5732cc212da00c0c = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_8690a9d4303a89a4d8a7ababf3d2d8e2733ec8f69a5da24e5732cc212da00c0c->enter($__internal_8690a9d4303a89a4d8a7ababf3d2d8e2733ec8f69a5da24e5732cc212da00c0c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        $__internal_0383f98f2a6fd582ed37a158b3d1b6f08a95179f5ac78d892ccf428efc26352a = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_0383f98f2a6fd582ed37a158b3d1b6f08a95179f5ac78d892ccf428efc26352a->enter($__internal_0383f98f2a6fd582ed37a158b3d1b6f08a95179f5ac78d892ccf428efc26352a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    ";
        $this->loadTemplate("navigator.html.twig", "provincia.html.twig", 4)->display($context);
        // line 5
        echo "    <div id=\"page-wrapper\">
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <h1 class=\"page-header\">Provincia</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <div class=\"panel panel-default\">
                    <div class=\"panel-heading\">
                        Informacion de circuitos, tributarios y votantes
                    </div>
                    <!-- /.panel-heading -->
                    <div class=\"panel-body\">
                        <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Votantes</th>
                                    <th>Mesas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 31
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["provincia"]) || array_key_exists("provincia", $context) ? $context["provincia"] : (function () { throw new Twig_Error_Runtime('Variable "provincia" does not exist.', 31, $this->getSourceContext()); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            if ((twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "tipo", array()) == "P")) {
                // line 32
                echo "                                <tr class=\"odd gradeX\">
                                    <td>";
                // line 33
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "nomb", array()), "html", null, true);
                echo "</td>
                                    <td>";
                // line 34
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "votantes", array()), "html", null, true);
                echo "</td>
                                    <td>";
                // line 35
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "mesasd", array()), "html", null, true);
                echo "-";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "mesash", array()), "html", null, true);
                echo "</td>
                                    <td><button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location.href='filtrosgobernador'\">Cargos gobernador</button>
                                    <button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location.href='filtrosdiputados'\">Cargos diputados</button>
                                    </td>
                                </tr>
                            ";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        echo "
                            </tbody>
                        </table>
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
        
        $__internal_0383f98f2a6fd582ed37a158b3d1b6f08a95179f5ac78d892ccf428efc26352a->leave($__internal_0383f98f2a6fd582ed37a158b3d1b6f08a95179f5ac78d892ccf428efc26352a_prof);

        
        $__internal_8690a9d4303a89a4d8a7ababf3d2d8e2733ec8f69a5da24e5732cc212da00c0c->leave($__internal_8690a9d4303a89a4d8a7ababf3d2d8e2733ec8f69a5da24e5732cc212da00c0c_prof);

    }

    // line 61
    public function block_final($context, array $blocks = array())
    {
        $__internal_d1cff6e7d7a989164480b368d95280ca2ad21682d86fbdc2130747e41a7517b6 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_d1cff6e7d7a989164480b368d95280ca2ad21682d86fbdc2130747e41a7517b6->enter($__internal_d1cff6e7d7a989164480b368d95280ca2ad21682d86fbdc2130747e41a7517b6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "final"));

        $__internal_8fe9a55c259613ddedbc76e103fb0d7e45cd23d218bdf8c5b2a454c0b6572e72 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_8fe9a55c259613ddedbc76e103fb0d7e45cd23d218bdf8c5b2a454c0b6572e72->enter($__internal_8fe9a55c259613ddedbc76e103fb0d7e45cd23d218bdf8c5b2a454c0b6572e72_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "final"));

        // line 62
        echo "     <!-- DataTables JavaScript -->
    <script src=\"";
        // line 63
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("/vendor/datatables/js/jquery.dataTables.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 64
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("/vendor/datatables-plugins/dataTables.bootstrap.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 65
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/datatables-responsive/dataTables.responsive.js"), "html", null, true);
        echo "\"></script>
    <script>
    \$(document).ready(function() {
        \$('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
    
    
";
        
        $__internal_8fe9a55c259613ddedbc76e103fb0d7e45cd23d218bdf8c5b2a454c0b6572e72->leave($__internal_8fe9a55c259613ddedbc76e103fb0d7e45cd23d218bdf8c5b2a454c0b6572e72_prof);

        
        $__internal_d1cff6e7d7a989164480b368d95280ca2ad21682d86fbdc2130747e41a7517b6->leave($__internal_d1cff6e7d7a989164480b368d95280ca2ad21682d86fbdc2130747e41a7517b6_prof);

    }

    public function getTemplateName()
    {
        return "provincia.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  160 => 65,  156 => 64,  152 => 63,  149 => 62,  140 => 61,  112 => 41,  97 => 35,  93 => 34,  89 => 33,  86 => 32,  81 => 31,  53 => 5,  50 => 4,  41 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"layout.html.twig\" %}

{% block content %}
    {% include \"navigator.html.twig\" %}
    <div id=\"page-wrapper\">
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <h1 class=\"page-header\">Provincia</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <div class=\"panel panel-default\">
                    <div class=\"panel-heading\">
                        Informacion de circuitos, tributarios y votantes
                    </div>
                    <!-- /.panel-heading -->
                    <div class=\"panel-body\">
                        <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Votantes</th>
                                    <th>Mesas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for item in provincia  if item.tipo == 'P'%}
                                <tr class=\"odd gradeX\">
                                    <td>{{item.nomb}}</td>
                                    <td>{{item.votantes}}</td>
                                    <td>{{item.mesasd}}-{{item.mesash}}</td>
                                    <td><button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location.href='filtrosgobernador'\">Cargos gobernador</button>
                                    <button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location.href='filtrosdiputados'\">Cargos diputados</button>
                                    </td>
                                </tr>
                            {% endfor %}

                            </tbody>
                        </table>
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
    <script>
    \$(document).ready(function() {
        \$('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
    
    
{% endblock %}

 
", "provincia.html.twig", "/var/www/elecciones/templates/provincia.html.twig");
    }
}
