<?php

/* circuitos.html.twig */
class __TwigTemplate_282bb96a01b4f2862550a0188b87c05f1741a535c738e80c264a9361ca5cd5d4 extends Twig_Template
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
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
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
        $context['_seq'] = twig_ensure_traversable(($context["circuitos"] ?? null));
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
    }

    // line 73
    public function block_final($context, array $blocks = array())
    {
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
        return array (  167 => 77,  163 => 76,  159 => 75,  156 => 74,  153 => 73,  131 => 53,  125 => 52,  117 => 49,  113 => 48,  109 => 47,  105 => 46,  101 => 45,  96 => 44,  92 => 43,  88 => 42,  83 => 41,  79 => 40,  76 => 39,  73 => 38,  69 => 37,  35 => 5,  32 => 4,  29 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "circuitos.html.twig", "/var/www/elecciones/templates/circuitos.html.twig");
    }
}
