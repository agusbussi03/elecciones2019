<?php

/* layout.html.twig */
class __TwigTemplate_c02139a91f4e6bdf809518463c31a58fb2fe9a296f8228e23d3785b3263183a3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'final' => array($this, 'block_final'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_eae2b43b5659b8bfaea098f7097f876f63bfeb6c18f1884b13138809f40e9901 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_eae2b43b5659b8bfaea098f7097f876f63bfeb6c18f1884b13138809f40e9901->enter($__internal_eae2b43b5659b8bfaea098f7097f876f63bfeb6c18f1884b13138809f40e9901_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "layout.html.twig"));

        $__internal_ec982711b02374f8e7dfc8fdfd1978314d6d195a3dc5a3ef07e1a32565343f4d = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_ec982711b02374f8e7dfc8fdfd1978314d6d195a3dc5a3ef07e1a32565343f4d->enter($__internal_ec982711b02374f8e7dfc8fdfd1978314d6d195a3dc5a3ef07e1a32565343f4d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "layout.html.twig"));

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
             <!-- DataTables CSS -->
    <link href=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/datatables-plugins/dataTables.bootstrap.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <!-- DataTables Responsive CSS -->
    <link href=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/datatables-responsive/dataTables.responsive.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]> <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script> <script src=\"https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js\"></script> <![endif]-->

        </head>

        <body>

            ";
        // line 42
        $this->displayBlock('content', $context, $blocks);
        // line 43
        echo "
            <!-- jQuery -->
            <script src=\"";
        // line 45
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/jquery/jquery.min.js"), "html", null, true);
        echo "\"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/bootstrap/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>

            <!-- Metis Menu Plugin JavaScript -->
            <script src=\"";
        // line 51
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/metisMenu/metisMenu.min.js"), "html", null, true);
        echo "\"></script>

            <!-- Morris Charts JavaScript -->
            <script src=\"";
        // line 54
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/raphael/raphael.min.js"), "html", null, true);
        echo "\"></script>
            <script src=\"";
        // line 55
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("vendor/morrisjs/morris.min.js"), "html", null, true);
        echo "\"></script>
            <!--script src=\"../data/morris-data.js\"></script-->

            <!-- Custom Theme JavaScript -->
            <script src=\"";
        // line 59
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("js/sb-admin-2.js"), "html", null, true);
        echo "\"></script>
            
              ";
        // line 61
        $this->displayBlock('final', $context, $blocks);
        echo " 

        </body>

    </html>
";
        
        $__internal_eae2b43b5659b8bfaea098f7097f876f63bfeb6c18f1884b13138809f40e9901->leave($__internal_eae2b43b5659b8bfaea098f7097f876f63bfeb6c18f1884b13138809f40e9901_prof);

        
        $__internal_ec982711b02374f8e7dfc8fdfd1978314d6d195a3dc5a3ef07e1a32565343f4d->leave($__internal_ec982711b02374f8e7dfc8fdfd1978314d6d195a3dc5a3ef07e1a32565343f4d_prof);

    }

    // line 13
    public function block_title($context, array $blocks = array())
    {
        $__internal_92d5b8179275fcbf5031e4a0c95b20aa81a232af7a33c6a257e2dddf794b0da7 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_92d5b8179275fcbf5031e4a0c95b20aa81a232af7a33c6a257e2dddf794b0da7->enter($__internal_92d5b8179275fcbf5031e4a0c95b20aa81a232af7a33c6a257e2dddf794b0da7_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        $__internal_77464e5ec7b3cea849ac4bc61c80763a9408bc09f64bb428814b78dfb56ae41d = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_77464e5ec7b3cea849ac4bc61c80763a9408bc09f64bb428814b78dfb56ae41d->enter($__internal_77464e5ec7b3cea849ac4bc61c80763a9408bc09f64bb428814b78dfb56ae41d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "";
        
        $__internal_77464e5ec7b3cea849ac4bc61c80763a9408bc09f64bb428814b78dfb56ae41d->leave($__internal_77464e5ec7b3cea849ac4bc61c80763a9408bc09f64bb428814b78dfb56ae41d_prof);

        
        $__internal_92d5b8179275fcbf5031e4a0c95b20aa81a232af7a33c6a257e2dddf794b0da7->leave($__internal_92d5b8179275fcbf5031e4a0c95b20aa81a232af7a33c6a257e2dddf794b0da7_prof);

    }

    // line 42
    public function block_content($context, array $blocks = array())
    {
        $__internal_66b35c612a6f5114c00f3b654b0664915f0a14ec6a04082062674ba386c8f682 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_66b35c612a6f5114c00f3b654b0664915f0a14ec6a04082062674ba386c8f682->enter($__internal_66b35c612a6f5114c00f3b654b0664915f0a14ec6a04082062674ba386c8f682_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        $__internal_3079f0fd872d1676c94f40e0b26f146b56b0e5c647c20d646e9b6a8a01b1cc05 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_3079f0fd872d1676c94f40e0b26f146b56b0e5c647c20d646e9b6a8a01b1cc05->enter($__internal_3079f0fd872d1676c94f40e0b26f146b56b0e5c647c20d646e9b6a8a01b1cc05_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        
        $__internal_3079f0fd872d1676c94f40e0b26f146b56b0e5c647c20d646e9b6a8a01b1cc05->leave($__internal_3079f0fd872d1676c94f40e0b26f146b56b0e5c647c20d646e9b6a8a01b1cc05_prof);

        
        $__internal_66b35c612a6f5114c00f3b654b0664915f0a14ec6a04082062674ba386c8f682->leave($__internal_66b35c612a6f5114c00f3b654b0664915f0a14ec6a04082062674ba386c8f682_prof);

    }

    // line 61
    public function block_final($context, array $blocks = array())
    {
        $__internal_de5b4219a2032b6790096e09eb3225e5943f6737040efaa446a1156a3a159277 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_de5b4219a2032b6790096e09eb3225e5943f6737040efaa446a1156a3a159277->enter($__internal_de5b4219a2032b6790096e09eb3225e5943f6737040efaa446a1156a3a159277_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "final"));

        $__internal_3881744af82a2effb0ad082dee716d2958c414290b3024738338ceb415b4db48 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_3881744af82a2effb0ad082dee716d2958c414290b3024738338ceb415b4db48->enter($__internal_3881744af82a2effb0ad082dee716d2958c414290b3024738338ceb415b4db48_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "final"));

        
        $__internal_3881744af82a2effb0ad082dee716d2958c414290b3024738338ceb415b4db48->leave($__internal_3881744af82a2effb0ad082dee716d2958c414290b3024738338ceb415b4db48_prof);

        
        $__internal_de5b4219a2032b6790096e09eb3225e5943f6737040efaa446a1156a3a159277->leave($__internal_de5b4219a2032b6790096e09eb3225e5943f6737040efaa446a1156a3a159277_prof);

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
        return array (  186 => 61,  169 => 42,  151 => 13,  135 => 61,  130 => 59,  123 => 55,  119 => 54,  113 => 51,  107 => 48,  101 => 45,  97 => 43,  95 => 42,  83 => 33,  78 => 31,  73 => 29,  67 => 26,  61 => 23,  55 => 20,  49 => 17,  44 => 14,  42 => 13,  28 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html lang=\"en\">

    <head>

        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <meta name=\"description\" content=\"\">
        <meta name=\"author\" content=\"\">

        <title>
            {% block title '' %}
                - My Silex Application</title>

            <!-- Bootstrap Core CSS -->
            <link href=\"{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}\" rel=\"stylesheet\">

            <!-- MetisMenu CSS -->
            <link href=\"{{ asset('vendor/metisMenu/metisMenu.min.css') }}\" rel=\"stylesheet\">

            <!-- Custom CSS -->
            <link href=\"{{ asset('css/sb-admin-2.css') }}\" rel=\"stylesheet\">

            <!-- Morris Charts CSS -->
            <link href=\"{{ asset('vendor/morrisjs/morris.css') }}\" rel=\"stylesheet\">

            <!-- Custom Fonts -->
            <link href=\"{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}\" rel=\"stylesheet\" type=\"text/css\">
             <!-- DataTables CSS -->
    <link href=\"{{ asset('vendor/datatables-plugins/dataTables.bootstrap.css') }}\" rel=\"stylesheet\">
    <!-- DataTables Responsive CSS -->
    <link href=\"{{ asset('vendor/datatables-responsive/dataTables.responsive.css') }}\" rel=\"stylesheet\">
            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]> <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script> <script src=\"https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js\"></script> <![endif]-->

        </head>

        <body>

            {% block content %}{% endblock %}

            <!-- jQuery -->
            <script src=\"{{ asset('vendor/jquery/jquery.min.js') }}\"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src=\"{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}\"></script>

            <!-- Metis Menu Plugin JavaScript -->
            <script src=\"{{ asset('vendor/metisMenu/metisMenu.min.js') }}\"></script>

            <!-- Morris Charts JavaScript -->
            <script src=\"{{ asset('vendor/raphael/raphael.min.js') }}\"></script>
            <script src=\"{{ asset('vendor/morrisjs/morris.min.js') }}\"></script>
            <!--script src=\"../data/morris-data.js\"></script-->

            <!-- Custom Theme JavaScript -->
            <script src=\"{{ asset('js/sb-admin-2.js') }}\"></script>
            
              {% block final %}{% endblock %} 

        </body>

    </html>
", "layout.html.twig", "/var/www/elecciones/templates/layout.html.twig");
    }
}
