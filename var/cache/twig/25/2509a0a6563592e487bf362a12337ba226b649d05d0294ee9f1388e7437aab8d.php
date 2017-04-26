<?php

/* layout.html.twig */
class __TwigTemplate_7bf844fd53f3f1e415ac20066bc35994df9a10064bb2597468f7a0fc8516c027 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">

    <head>

        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <meta name=\"description\" content=\"\">
        <meta name=\"author\" content=\"\">

        <title>
            ";
        // line 13
        $this->displayBlock('title', $context, $blocks);
        // line 14
        echo "                - My Silex Application</title>

            <!-- Bootstrap Core CSS -->
            <link href=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/bootstrap/css/bootstrap.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">

            <!-- MetisMenu CSS -->
            <link href=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/metisMenu/metisMenu.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">

            <!-- Custom CSS -->
            <link href=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("css/sb-admin-2.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">

            <!-- Morris Charts CSS -->
            <link href=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/morrisjs/morris.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">

            <!-- Custom Fonts -->
            <link href=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/font-awesome/css/font-awesome.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\">

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]> <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script> <script src=\"https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js\"></script> <![endif]-->

        </head>

        <body>

            ";
        // line 39
        $this->displayBlock('content', $context, $blocks);
        // line 40
        echo "
            <!-- jQuery -->
            <script src=\"";
        // line 42
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/jquery/jquery.min.js"), "html", null, true);
        echo "\"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src=\"";
        // line 45
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/bootstrap/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>

            <!-- Metis Menu Plugin JavaScript -->
            <script src=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/metisMenu/metisMenu.min.js"), "html", null, true);
        echo "\"></script>

            <!-- Morris Charts JavaScript -->
            <script src=\"";
        // line 51
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/raphael/raphael.min.js"), "html", null, true);
        echo "\"></script>
            <script src=\"";
        // line 52
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/morrisjs/morris.min.js"), "html", null, true);
        echo "\"></script>
            <script src=\"../data/morris-data.js\"></script>

            <!-- Custom Theme JavaScript -->
            <script src=\"";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("js/sb-admin-2.js"), "html", null, true);
        echo "\"></script>

        </body>

    </html>
";
    }

    // line 13
    public function block_title($context, array $blocks = array())
    {
        echo "";
    }

    // line 39
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  130 => 39,  124 => 13,  114 => 56,  107 => 52,  103 => 51,  97 => 48,  91 => 45,  85 => 42,  81 => 40,  79 => 39,  66 => 29,  60 => 26,  54 => 23,  48 => 20,  42 => 17,  37 => 14,  35 => 13,  21 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "layout.html.twig", "/var/www/elecciones/templates/layout.html.twig");
    }
}
