<?php

/* secciones.html.twig */
class __TwigTemplate_d37bccb4d0f1ad894a3e772862ed867f320e9f459bb0659785f0ba0d417230fe extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "secciones.html.twig", 1);
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
        $__internal_9006b8063f8eccddb4c17315852b1b12b97a9409ce8ea26a3152f05bfb76f329 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_9006b8063f8eccddb4c17315852b1b12b97a9409ce8ea26a3152f05bfb76f329->enter($__internal_9006b8063f8eccddb4c17315852b1b12b97a9409ce8ea26a3152f05bfb76f329_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "secciones.html.twig"));

        $__internal_cb020ec7b5cc3c0d5aa2e9fc81f28d392329587363d6951f34cbff2f5a6c6d0a = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_cb020ec7b5cc3c0d5aa2e9fc81f28d392329587363d6951f34cbff2f5a6c6d0a->enter($__internal_cb020ec7b5cc3c0d5aa2e9fc81f28d392329587363d6951f34cbff2f5a6c6d0a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "secciones.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_9006b8063f8eccddb4c17315852b1b12b97a9409ce8ea26a3152f05bfb76f329->leave($__internal_9006b8063f8eccddb4c17315852b1b12b97a9409ce8ea26a3152f05bfb76f329_prof);

        
        $__internal_cb020ec7b5cc3c0d5aa2e9fc81f28d392329587363d6951f34cbff2f5a6c6d0a->leave($__internal_cb020ec7b5cc3c0d5aa2e9fc81f28d392329587363d6951f34cbff2f5a6c6d0a_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_ddd3f182cec9cfa95415dfa5eb47f0360b372527b22dde37c480ec464a7a183a = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ddd3f182cec9cfa95415dfa5eb47f0360b372527b22dde37c480ec464a7a183a->enter($__internal_ddd3f182cec9cfa95415dfa5eb47f0360b372527b22dde37c480ec464a7a183a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        $__internal_0fb75535a2ea446098a48985cf6816fbf9d2cf86c6d0fc2aeca29465070ead3b = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_0fb75535a2ea446098a48985cf6816fbf9d2cf86c6d0fc2aeca29465070ead3b->enter($__internal_0fb75535a2ea446098a48985cf6816fbf9d2cf86c6d0fc2aeca29465070ead3b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    ";
        $this->loadTemplate("navigator.html.twig", "secciones.html.twig", 4)->display($context);
        // line 5
        echo "    <div id=\"page-wrapper\">
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <h1 class=\"page-header\">Secciones</h1>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 38
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["secciones"]) || array_key_exists("secciones", $context) ? $context["secciones"] : (function () { throw new Twig_Error_Runtime('Variable "secciones" does not exist.', 38, $this->getSourceContext()); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            if ((twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "tipo", array()) == "S")) {
                // line 39
                echo "
                                <tr class=\"odd gradeX\">
                                    <td>";
                // line 41
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "sec", array()), "html", null, true);
                echo "</td>
                                    <td>";
                // line 42
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "cirnro", array()), "html", null, true);
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "cirlet", array()), "html", null, true);
                echo "</td>
                                    <td>";
                // line 43
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "tipo", array()), "html", null, true);
                echo "</td>
                                    <td>";
                // line 44
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "nomb", array()), "html", null, true);
                echo "</td>
                                    <td>";
                // line 45
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "cirnrotr", array()), "html", null, true);
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "cirlettr", array()), "html", null, true);
                echo "</td>
                                    <td>";
                // line 46
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "int", array()), "html", null, true);
                echo "</td>
                                    <td>";
                // line 47
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "cont", array()), "html", null, true);
                echo "</td>
                                    <td>";
                // line 48
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "cons", array()), "html", null, true);
                echo "</td>
                                    <td>";
                // line 49
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "votantes", array()), "html", null, true);
                echo "</td>
                                    <td>";
                // line 50
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "mesasd", array()), "html", null, true);
                echo "-";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "mesash", array()), "html", null, true);
                echo "</td>
                                    <td><button type=\"button\" class=\"btn btn-primary\" 
                                                onclick=\"window.location.href='filtrossenador/";
                // line 52
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "sec", array()), "html", null, true);
                echo "'\">Cargos diputados</button>
                                    </td>
                                   
                                </tr>
                            ";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 57
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
        
        $__internal_0fb75535a2ea446098a48985cf6816fbf9d2cf86c6d0fc2aeca29465070ead3b->leave($__internal_0fb75535a2ea446098a48985cf6816fbf9d2cf86c6d0fc2aeca29465070ead3b_prof);

        
        $__internal_ddd3f182cec9cfa95415dfa5eb47f0360b372527b22dde37c480ec464a7a183a->leave($__internal_ddd3f182cec9cfa95415dfa5eb47f0360b372527b22dde37c480ec464a7a183a_prof);

    }

    // line 77
    public function block_final($context, array $blocks = array())
    {
        $__internal_0e8a415cf3ed316be9d6253c28fe6903c7b60097e1d3934d585242d2dcaf5cd8 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0e8a415cf3ed316be9d6253c28fe6903c7b60097e1d3934d585242d2dcaf5cd8->enter($__internal_0e8a415cf3ed316be9d6253c28fe6903c7b60097e1d3934d585242d2dcaf5cd8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "final"));

        $__internal_99f2ba1625be5dda74f1a9b03b8f1a09670806cc0e0d06def8e6270ad65415c2 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_99f2ba1625be5dda74f1a9b03b8f1a09670806cc0e0d06def8e6270ad65415c2->enter($__internal_99f2ba1625be5dda74f1a9b03b8f1a09670806cc0e0d06def8e6270ad65415c2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "final"));

        // line 78
        echo "     <!-- DataTables JavaScript -->
    <script src=\"";
        // line 79
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("/vendor/datatables/js/jquery.dataTables.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 80
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("/vendor/datatables-plugins/dataTables.bootstrap.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 81
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
        
        $__internal_99f2ba1625be5dda74f1a9b03b8f1a09670806cc0e0d06def8e6270ad65415c2->leave($__internal_99f2ba1625be5dda74f1a9b03b8f1a09670806cc0e0d06def8e6270ad65415c2_prof);

        
        $__internal_0e8a415cf3ed316be9d6253c28fe6903c7b60097e1d3934d585242d2dcaf5cd8->leave($__internal_0e8a415cf3ed316be9d6253c28fe6903c7b60097e1d3934d585242d2dcaf5cd8_prof);

    }

    public function getTemplateName()
    {
        return "secciones.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  202 => 81,  198 => 80,  194 => 79,  191 => 78,  182 => 77,  154 => 57,  142 => 52,  135 => 50,  131 => 49,  127 => 48,  123 => 47,  119 => 46,  114 => 45,  110 => 44,  106 => 43,  101 => 42,  97 => 41,  93 => 39,  88 => 38,  53 => 5,  50 => 4,  41 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"layout.html.twig\" %}

{% block content %}
    {% include \"navigator.html.twig\" %}
    <div id=\"page-wrapper\">
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <h1 class=\"page-header\">Secciones</h1>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for item in secciones  if item.tipo == 'S'%}

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
                                    <td><button type=\"button\" class=\"btn btn-primary\" 
                                                onclick=\"window.location.href='filtrossenador/{{item.sec}}'\">Cargos diputados</button>
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

 
", "secciones.html.twig", "/var/www/elecciones/templates/secciones.html.twig");
    }
}
