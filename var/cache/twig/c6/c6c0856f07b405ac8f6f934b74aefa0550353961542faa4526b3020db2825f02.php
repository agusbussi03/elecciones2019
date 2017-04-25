<?php

/* circuitos.html.twig */
class __TwigTemplate_59ef0147e8837871bb1ac948773642a1df00f814e3515f6060e9d9316e53663f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "circuitos.html.twig", 1);
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
        $__internal_18a9a9ad71f28fed2cbdea3835dc893a1e1e6740319e4f7c4163bb4393c87f52 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_18a9a9ad71f28fed2cbdea3835dc893a1e1e6740319e4f7c4163bb4393c87f52->enter($__internal_18a9a9ad71f28fed2cbdea3835dc893a1e1e6740319e4f7c4163bb4393c87f52_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "circuitos.html.twig"));

        $__internal_ed90ae98bdc89628b6163bc853ded15e053215a1fda040caf2ca9e592a114685 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_ed90ae98bdc89628b6163bc853ded15e053215a1fda040caf2ca9e592a114685->enter($__internal_ed90ae98bdc89628b6163bc853ded15e053215a1fda040caf2ca9e592a114685_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "circuitos.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_18a9a9ad71f28fed2cbdea3835dc893a1e1e6740319e4f7c4163bb4393c87f52->leave($__internal_18a9a9ad71f28fed2cbdea3835dc893a1e1e6740319e4f7c4163bb4393c87f52_prof);

        
        $__internal_ed90ae98bdc89628b6163bc853ded15e053215a1fda040caf2ca9e592a114685->leave($__internal_ed90ae98bdc89628b6163bc853ded15e053215a1fda040caf2ca9e592a114685_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_6488e3d159f30706ddad8bc5beb22d05eecb682f4dffb7335bd933498327a9ea = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_6488e3d159f30706ddad8bc5beb22d05eecb682f4dffb7335bd933498327a9ea->enter($__internal_6488e3d159f30706ddad8bc5beb22d05eecb682f4dffb7335bd933498327a9ea_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        $__internal_1685a88d8eccf469083faa858822f1c7a2a5c20c34566a9fab3f45c0abdf8911 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_1685a88d8eccf469083faa858822f1c7a2a5c20c34566a9fab3f45c0abdf8911->enter($__internal_1685a88d8eccf469083faa858822f1c7a2a5c20c34566a9fab3f45c0abdf8911_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    ";
        $this->loadTemplate("navigator.html.twig", "circuitos.html.twig", 4)->display($context);
        // line 5
        echo "    <div id=\"page-wrapper\">
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <h1 class=\"page-header\">Circuitos</h1>
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
                                    <th>Seccion</th>
                                    <th>Circuito</th>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                    <th>Tributa</th>
                                    <th>Intend.</th>
                                    <th>Cons. T.</th>
                                    <th>Cons. S.</th>
                                    <th>Votantes</th>
                                    <th>Mesas</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 37
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["circuitos"]) || array_key_exists("circuitos", $context) ? $context["circuitos"] : (function () { throw new Twig_Error_Runtime('Variable "circuitos" does not exist.', 37, $this->getSourceContext()); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 38
            echo "                                    ";
            if ((((twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "tipo", array()) == "M") || (twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "tipo", array()) == "C")) || (twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "tipo", array()) == "T"))) {
                // line 39
                echo "                                        <tr class=\"odd gradeX\">
                                            <td>";
                // line 40
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "sec", array()), "html", null, true);
                echo "</td>
                                            <td>";
                // line 41
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "cirnro", array()), "html", null, true);
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "cirlet", array()), "html", null, true);
                echo "</td>
                                            <td>";
                // line 42
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "tipo", array()), "html", null, true);
                echo "</td>
                                            <td>";
                // line 43
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "nomb", array()), "html", null, true);
                echo "</td>
                                            <td>";
                // line 44
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "cirnrotr", array()), "html", null, true);
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "cirlettr", array()), "html", null, true);
                echo "</td>
                                            <td>";
                // line 45
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "int", array()), "html", null, true);
                echo "</td>
                                            <td>";
                // line 46
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "cont", array()), "html", null, true);
                echo "</td>
                                            <td>";
                // line 47
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "cons", array()), "html", null, true);
                echo "</td>
                                            <td>";
                // line 48
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "votantes", array()), "html", null, true);
                echo "</td>
                                            <td>";
                // line 49
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "mesasd", array()), "html", null, true);
                echo "-";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "mesash", array()), "html", null, true);
                echo "</td>
                                        </tr>
                                    ";
            }
            // line 52
            echo "                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 53
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
        
        $__internal_1685a88d8eccf469083faa858822f1c7a2a5c20c34566a9fab3f45c0abdf8911->leave($__internal_1685a88d8eccf469083faa858822f1c7a2a5c20c34566a9fab3f45c0abdf8911_prof);

        
        $__internal_6488e3d159f30706ddad8bc5beb22d05eecb682f4dffb7335bd933498327a9ea->leave($__internal_6488e3d159f30706ddad8bc5beb22d05eecb682f4dffb7335bd933498327a9ea_prof);

    }

    // line 73
    public function block_final($context, array $blocks = array())
    {
        $__internal_ee04230a5975958aa1c2e3f2e64bdd39891e33a296d74412196b05c865d11920 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ee04230a5975958aa1c2e3f2e64bdd39891e33a296d74412196b05c865d11920->enter($__internal_ee04230a5975958aa1c2e3f2e64bdd39891e33a296d74412196b05c865d11920_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "final"));

        $__internal_84e4cc92e03d11ef6b40511b6f84c18552781022a6e05c1aaaf4e985985014fe = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_84e4cc92e03d11ef6b40511b6f84c18552781022a6e05c1aaaf4e985985014fe->enter($__internal_84e4cc92e03d11ef6b40511b6f84c18552781022a6e05c1aaaf4e985985014fe_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "final"));

        // line 74
        echo "    <!-- DataTables JavaScript -->
    <script src=\"";
        // line 75
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("/vendor/datatables/js/jquery.dataTables.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 76
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("/vendor/datatables-plugins/dataTables.bootstrap.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 77
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/datatables-responsive/dataTables.responsive.js"), "html", null, true);
        echo "\"></script>
    <script>
        \$(document).ready(function () {
            \$('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>


";
        
        $__internal_84e4cc92e03d11ef6b40511b6f84c18552781022a6e05c1aaaf4e985985014fe->leave($__internal_84e4cc92e03d11ef6b40511b6f84c18552781022a6e05c1aaaf4e985985014fe_prof);

        
        $__internal_ee04230a5975958aa1c2e3f2e64bdd39891e33a296d74412196b05c865d11920->leave($__internal_ee04230a5975958aa1c2e3f2e64bdd39891e33a296d74412196b05c865d11920_prof);

    }

    public function getTemplateName()
    {
        return "circuitos.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  197 => 77,  193 => 76,  189 => 75,  186 => 74,  177 => 73,  149 => 53,  143 => 52,  135 => 49,  131 => 48,  127 => 47,  123 => 46,  119 => 45,  114 => 44,  110 => 43,  106 => 42,  101 => 41,  97 => 40,  94 => 39,  91 => 38,  87 => 37,  53 => 5,  50 => 4,  41 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"layout.html.twig\" %}

{% block content %}
    {% include \"navigator.html.twig\" %}
    <div id=\"page-wrapper\">
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <h1 class=\"page-header\">Circuitos</h1>
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
                                    <th>Seccion</th>
                                    <th>Circuito</th>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                    <th>Tributa</th>
                                    <th>Intend.</th>
                                    <th>Cons. T.</th>
                                    <th>Cons. S.</th>
                                    <th>Votantes</th>
                                    <th>Mesas</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for item in circuitos%}
                                    {% if item.tipo == 'M' or item.tipo == 'C' or item.tipo == 'T'%}
                                        <tr class=\"odd gradeX\">
                                            <td>{{item.sec}}</td>
                                            <td>{{item.cirnro}}{{item.cirlet}}</td>
                                            <td>{{item.tipo}}</td>
                                            <td>{{item.nomb}}</td>
                                            <td>{{item.cirnrotr}}{{item.cirlettr}}</td>
                                            <td>{{item.int}}</td>
                                            <td>{{item.cont}}</td>
                                            <td>{{item.cons}}</td>
                                            <td>{{item.votantes}}</td>
                                            <td>{{item.mesasd}}-{{item.mesash}}</td>
                                        </tr>
                                    {% endif %}
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
        \$(document).ready(function () {
            \$('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>


{% endblock %}


", "circuitos.html.twig", "/var/www/elecciones/templates/circuitos.html.twig");
    }
}
