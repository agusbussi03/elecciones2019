<?php

/* index.html.twig */
class __TwigTemplate_1d318dfb8846d5661d3fe79b8b18650f564c728ca21c0ec65eb7a0889dc9d8ec extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "index.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_0fb2ab5b645d1c5fabdacc839ede913a3808d30e1434b08ad2986985e1833226 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0fb2ab5b645d1c5fabdacc839ede913a3808d30e1434b08ad2986985e1833226->enter($__internal_0fb2ab5b645d1c5fabdacc839ede913a3808d30e1434b08ad2986985e1833226_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "index.html.twig"));

        $__internal_449cd92353afc143810f8ce30dc03d23f5bc86a2807a8e6946a5a5254f7a740d = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_449cd92353afc143810f8ce30dc03d23f5bc86a2807a8e6946a5a5254f7a740d->enter($__internal_449cd92353afc143810f8ce30dc03d23f5bc86a2807a8e6946a5a5254f7a740d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "index.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_0fb2ab5b645d1c5fabdacc839ede913a3808d30e1434b08ad2986985e1833226->leave($__internal_0fb2ab5b645d1c5fabdacc839ede913a3808d30e1434b08ad2986985e1833226_prof);

        
        $__internal_449cd92353afc143810f8ce30dc03d23f5bc86a2807a8e6946a5a5254f7a740d->leave($__internal_449cd92353afc143810f8ce30dc03d23f5bc86a2807a8e6946a5a5254f7a740d_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_7126dee8befacd6b3e54b1980425a8409b7d7e9976d0b77cb14f91ad841d3103 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_7126dee8befacd6b3e54b1980425a8409b7d7e9976d0b77cb14f91ad841d3103->enter($__internal_7126dee8befacd6b3e54b1980425a8409b7d7e9976d0b77cb14f91ad841d3103_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        $__internal_93e9de9ea9c1b427a2e96dfdb78657117a504a5d91ec9911ed26022ffe86b8a6 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_93e9de9ea9c1b427a2e96dfdb78657117a504a5d91ec9911ed26022ffe86b8a6->enter($__internal_93e9de9ea9c1b427a2e96dfdb78657117a504a5d91ec9911ed26022ffe86b8a6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "            ";
        $this->loadTemplate("navigator.html.twig", "index.html.twig", 4)->display($context);
        // line 5
        echo "            <div id=\"page-wrapper\">
                   <div class=\"row\">
                       <div class=\"col-lg-12\">
                           <h1 class=\"page-header\">Dashboard</h1>
                       </div>
                       <!-- /.col-lg-12 -->
                   </div>
                   <!-- /.row -->
                   <div class=\"row\">
                       <div class=\"col-lg-3 col-md-6\">
                           <div class=\"panel panel-primary\">
                               <div class=\"panel-heading\">
                                   <div class=\"row\">
                                       <div class=\"col-xs-3\">
                                           <i class=\"fa fa-inbox fa-5x\"></i>
                                       </div>
                                       <div class=\"col-xs-9 text-right\">
                                           <div class=\"huge\">26 / 89</div>
                                           <div>Mesas cargadas</div>
                                       </div>
                                   </div>
                               </div>
                               <a href=\"#\">
                                   <div class=\"panel-footer\">
                                       <span class=\"pull-left\">Ver mas >></span>
                                       <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                       <div class=\"clearfix\"></div>
                                   </div>
                               </a>
                           </div>
                       </div>
                       <div class=\"col-lg-3 col-md-6\">
                           <div class=\"panel panel-green\">
                               <div class=\"panel-heading\">
                                   <div class=\"row\">
                                       <div class=\"col-xs-3\">
                                           <i class=\"fa fa-tasks fa-5x\"></i>
                                       </div>
                                       <div class=\"col-xs-9 text-right\">
                                           <div class=\"huge\">12 / 15</div>
                                           <div>Circuitos completados</div>
                                       </div>
                                   </div>
                               </div>
                               <a href=\"#\">
                                   <div class=\"panel-footer\">
                                       <span class=\"pull-left\">Detalles</span>
                                       <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                       <div class=\"clearfix\"></div>
                                   </div>
                               </a>
                           </div>
                       </div>
                       <div class=\"col-lg-3 col-md-6\">
                           <div class=\"panel panel-yellow\">
                               <div class=\"panel-heading\">
                                   <div class=\"row\">
                                       <div class=\"col-xs-3\">
                                           <i class=\"fa fa-cloud fa-5x\"></i>
                                       </div>
                                       <div class=\"col-xs-9 text-right\">
                                           <div class=\"huge\">25%</div>
                                           <div>Cargas online</div>
                                       </div>
                                   </div>
                               </div>
                               <a href=\"#\">
                                   <div class=\"panel-footer\">
                                       <span class=\"pull-left\">Lista completa</span>
                                       <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                       <div class=\"clearfix\"></div>
                                   </div>
                               </a>
                           </div>
                       </div>
                       <div class=\"col-lg-3 col-md-6\">
                           <div class=\"panel panel-red\">
                               <div class=\"panel-heading\">
                                   <div class=\"row\">
                                       <div class=\"col-xs-3\">
                                           <i class=\"fa fa-support fa-5x\"></i>
                                       </div>
                                       <div class=\"col-xs-9 text-right\">
                                           <div class=\"huge\">0</div>
                                           <div>Cargos provinciales</div>
                                       </div>
                                   </div>
                               </div>
                               <a href=\"#\">
                                   <div class=\"panel-footer\">
                                       <span class=\"pull-left\">Detalles</span>
                                       <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                       <div class=\"clearfix\"></div>
                                   </div>
                               </a>
                           </div>
                       </div>
                   </div>
                   <!-- /.row -->
                   <div class=\"row\">
                       <div class=\"col-lg-8\">
                           <div class=\"panel panel-default\">
                               <div class=\"panel-heading\">
                                   <i class=\"fa fa-bar-chart-o fa-fw\"></i> Area Chart Example
                                   <div class=\"pull-right\">
                                       <div class=\"btn-group\">
                                           <button type=\"button\" class=\"btn btn-default btn-xs dropdown-toggle\" data-toggle=\"dropdown\">
                                               Actions
                                               <span class=\"caret\"></span>
                                           </button>
                                           <ul class=\"dropdown-menu pull-right\" role=\"menu\">
                                               <li><a href=\"#\">Action</a>
                                               </li>
                                               <li><a href=\"#\">Another action</a>
                                               </li>
                                               <li><a href=\"#\">Something else here</a>
                                               </li>
                                               <li class=\"divider\"></li>
                                               <li><a href=\"#\">Separated link</a>
                                               </li>
                                           </ul>
                                       </div>
                                   </div>
                               </div>
                               <!-- /.panel-heading -->
                               <div class=\"panel-body\">
                                   <div id=\"morris-area-chart\"></div>
                               </div>
                               <!-- /.panel-body -->
                           </div>
                           <!-- /.panel -->
                           <div class=\"panel panel-default\">
                               <div class=\"panel-heading\">
                                   <i class=\"fa fa-bar-chart-o fa-fw\"></i> Bar Chart Example
                                   <div class=\"pull-right\">
                                       <div class=\"btn-group\">
                                           <button type=\"button\" class=\"btn btn-default btn-xs dropdown-toggle\" data-toggle=\"dropdown\">
                                               Actions
                                               <span class=\"caret\"></span>
                                           </button>
                                           <ul class=\"dropdown-menu pull-right\" role=\"menu\">
                                               <li><a href=\"#\">Action</a>
                                               </li>
                                               <li><a href=\"#\">Another action</a>
                                               </li>
                                               <li><a href=\"#\">Something else here</a>
                                               </li>
                                               <li class=\"divider\"></li>
                                               <li><a href=\"#\">Separated link</a>
                                               </li>
                                           </ul>
                                       </div>
                                   </div>
                               </div>
                               <!-- /.panel-heading -->
                               <div class=\"panel-body\">
                                   <div class=\"row\">
                                       <div class=\"col-lg-4\">
                                           <div class=\"table-responsive\">
                                               <table class=\"table table-bordered table-hover table-striped\">
                                                   <thead>
                                                       <tr>
                                                           <th>#</th>
                                                           <th>Date</th>
                                                           <th>Time</th>
                                                           <th>Amount</th>
                                                       </tr>
                                                   </thead>
                                                   <tbody>
                                                       <tr>
                                                           <td>3326</td>
                                                           <td>10/21/2013</td>
                                                           <td>3:29 PM</td>
                                                           <td>\$321.33</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3325</td>
                                                           <td>10/21/2013</td>
                                                           <td>3:20 PM</td>
                                                           <td>\$234.34</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3324</td>
                                                           <td>10/21/2013</td>
                                                           <td>3:03 PM</td>
                                                           <td>\$724.17</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3323</td>
                                                           <td>10/21/2013</td>
                                                           <td>3:00 PM</td>
                                                           <td>\$23.71</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3322</td>
                                                           <td>10/21/2013</td>
                                                           <td>2:49 PM</td>
                                                           <td>\$8345.23</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3321</td>
                                                           <td>10/21/2013</td>
                                                           <td>2:23 PM</td>
                                                           <td>\$245.12</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3320</td>
                                                           <td>10/21/2013</td>
                                                           <td>2:15 PM</td>
                                                           <td>\$5663.54</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3319</td>
                                                           <td>10/21/2013</td>
                                                           <td>2:13 PM</td>
                                                           <td>\$943.45</td>
                                                       </tr>
                                                   </tbody>
                                               </table>
                                           </div>
                                           <!-- /.table-responsive -->
                                       </div>
                                       <!-- /.col-lg-4 (nested) -->
                                       <div class=\"col-lg-8\">
                                           <div id=\"morris-bar-chart\"></div>
                                       </div>
                                       <!-- /.col-lg-8 (nested) -->
                                   </div>
                                   <!-- /.row -->
                               </div>
                               <!-- /.panel-body -->
                           </div>

                       </div>
                       <!-- /.col-lg-8 -->
                       <div class=\"col-lg-4\">
                           <div class=\"panel panel-default\">
                               <div class=\"panel-heading\">
                                   <i class=\"fa fa-bell fa-fw\"></i> Notifications Panel
                               </div>
                               <!-- /.panel-heading -->
                               <div class=\"panel-body\">
                                   <div class=\"list-group\">
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-comment fa-fw\"></i> New Comment
                                           <span class=\"pull-right text-muted small\"><em>4 minutes ago</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-twitter fa-fw\"></i> 3 New Followers
                                           <span class=\"pull-right text-muted small\"><em>12 minutes ago</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-envelope fa-fw\"></i> Message Sent
                                           <span class=\"pull-right text-muted small\"><em>27 minutes ago</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-tasks fa-fw\"></i> New Task
                                           <span class=\"pull-right text-muted small\"><em>43 minutes ago</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-upload fa-fw\"></i> Server Rebooted
                                           <span class=\"pull-right text-muted small\"><em>11:32 AM</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-bolt fa-fw\"></i> Server Crashed!
                                           <span class=\"pull-right text-muted small\"><em>11:13 AM</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-warning fa-fw\"></i> Server Not Responding
                                           <span class=\"pull-right text-muted small\"><em>10:57 AM</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-shopping-cart fa-fw\"></i> New Order Placed
                                           <span class=\"pull-right text-muted small\"><em>9:49 AM</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-money fa-fw\"></i> Payment Received
                                           <span class=\"pull-right text-muted small\"><em>Yesterday</em>
                                           </span>
                                       </a>
                                   </div>
                                   <!-- /.list-group -->
                                   <a href=\"#\" class=\"btn btn-default btn-block\">View All Alerts</a>
                               </div>
                               <!-- /.panel-body -->
                           </div>
                           <!-- /.panel -->
                           <div class=\"panel panel-default\">
                               <div class=\"panel-heading\">
                                   <i class=\"fa fa-bar-chart-o fa-fw\"></i> Donut Chart Example
                               </div>
                               <div class=\"panel-body\">
                                   <div id=\"morris-donut-chart\"></div>
                                   <a href=\"#\" class=\"btn btn-default btn-block\">View Details</a>
                               </div>
                               <!-- /.panel-body -->
                           </div>
                           <!-- /.panel -->
                           <div class=\"chat-panel panel panel-default\">
                               <div class=\"panel-heading\">
                                   <i class=\"fa fa-comments fa-fw\"></i> Chat
                                   <div class=\"btn-group pull-right\">
                                       <button type=\"button\" class=\"btn btn-default btn-xs dropdown-toggle\" data-toggle=\"dropdown\">
                                           <i class=\"fa fa-chevron-down\"></i>
                                       </button>
                                       <ul class=\"dropdown-menu slidedown\">
                                           <li>
                                               <a href=\"#\">
                                                   <i class=\"fa fa-refresh fa-fw\"></i> Refresh
                                               </a>
                                           </li>
                                           <li>
                                               <a href=\"#\">
                                                   <i class=\"fa fa-check-circle fa-fw\"></i> Available
                                               </a>
                                           </li>
                                           <li>
                                               <a href=\"#\">
                                                   <i class=\"fa fa-times fa-fw\"></i> Busy
                                               </a>
                                           </li>
                                           <li>
                                               <a href=\"#\">
                                                   <i class=\"fa fa-clock-o fa-fw\"></i> Away
                                               </a>
                                           </li>
                                           <li class=\"divider\"></li>
                                           <li>
                                               <a href=\"#\">
                                                   <i class=\"fa fa-sign-out fa-fw\"></i> Sign Out
                                               </a>
                                           </li>
                                       </ul>
                                   </div>
                               </div>
                               <!-- /.panel-heading -->
                               <div class=\"panel-body\">
                                   <ul class=\"chat\">
                                       <li class=\"left clearfix\">
                                           <span class=\"chat-img pull-left\">
                                               <img src=\"http://placehold.it/50/55C1E7/fff\" alt=\"User Avatar\" class=\"img-circle\" />
                                           </span>
                                           <div class=\"chat-body clearfix\">
                                               <div class=\"header\">
                                                   <strong class=\"primary-font\">Jack Sparrow</strong>
                                                   <small class=\"pull-right text-muted\">
                                                       <i class=\"fa fa-clock-o fa-fw\"></i> 12 mins ago
                                                   </small>
                                               </div>
                                               <p>
                                                   Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                               </p>
                                           </div>
                                       </li>
                                       <li class=\"right clearfix\">
                                           <span class=\"chat-img pull-right\">
                                               <img src=\"http://placehold.it/50/FA6F57/fff\" alt=\"User Avatar\" class=\"img-circle\" />
                                           </span>
                                           <div class=\"chat-body clearfix\">
                                               <div class=\"header\">
                                                   <small class=\" text-muted\">
                                                       <i class=\"fa fa-clock-o fa-fw\"></i> 13 mins ago</small>
                                                   <strong class=\"pull-right primary-font\">Bhaumik Patel</strong>
                                               </div>
                                               <p>
                                                   Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                               </p>
                                           </div>
                                       </li>
                                       <li class=\"left clearfix\">
                                           <span class=\"chat-img pull-left\">
                                               <img src=\"http://placehold.it/50/55C1E7/fff\" alt=\"User Avatar\" class=\"img-circle\" />
                                           </span>
                                           <div class=\"chat-body clearfix\">
                                               <div class=\"header\">
                                                   <strong class=\"primary-font\">Jack Sparrow</strong>
                                                   <small class=\"pull-right text-muted\">
                                                       <i class=\"fa fa-clock-o fa-fw\"></i> 14 mins ago</small>
                                               </div>
                                               <p>
                                                   Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                               </p>
                                           </div>
                                       </li>
                                       <li class=\"right clearfix\">
                                           <span class=\"chat-img pull-right\">
                                               <img src=\"http://placehold.it/50/FA6F57/fff\" alt=\"User Avatar\" class=\"img-circle\" />
                                           </span>
                                           <div class=\"chat-body clearfix\">
                                               <div class=\"header\">
                                                   <small class=\" text-muted\">
                                                       <i class=\"fa fa-clock-o fa-fw\"></i> 15 mins ago</small>
                                                   <strong class=\"pull-right primary-font\">Bhaumik Patel</strong>
                                               </div>
                                               <p>
                                                   Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                               </p>
                                           </div>
                                       </li>
                                   </ul>
                               </div>
                               <!-- /.panel-body -->
                               <div class=\"panel-footer\">
                                   <div class=\"input-group\">
                                       <input id=\"btn-input\" type=\"text\" class=\"form-control input-sm\" placeholder=\"Type your message here...\" />
                                       <span class=\"input-group-btn\">
                                           <button class=\"btn btn-warning btn-sm\" id=\"btn-chat\">
                                               Send
                                           </button>
                                       </span>
                                   </div>
                               </div>
                               <!-- /.panel-footer -->
                           </div>
                           <!-- /.panel .chat-panel -->
                       </div>
                       <!-- /.col-lg-4 -->
                   </div>
                   <!-- /.row -->
               </div>
               <!-- /#page-wrapper -->

           </div>
           <!-- /#wrapper -->
";
        
        $__internal_93e9de9ea9c1b427a2e96dfdb78657117a504a5d91ec9911ed26022ffe86b8a6->leave($__internal_93e9de9ea9c1b427a2e96dfdb78657117a504a5d91ec9911ed26022ffe86b8a6_prof);

        
        $__internal_7126dee8befacd6b3e54b1980425a8409b7d7e9976d0b77cb14f91ad841d3103->leave($__internal_7126dee8befacd6b3e54b1980425a8409b7d7e9976d0b77cb14f91ad841d3103_prof);

    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 5,  49 => 4,  40 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"layout.html.twig\" %}

{% block content %}
            {% include \"navigator.html.twig\" %}
            <div id=\"page-wrapper\">
                   <div class=\"row\">
                       <div class=\"col-lg-12\">
                           <h1 class=\"page-header\">Dashboard</h1>
                       </div>
                       <!-- /.col-lg-12 -->
                   </div>
                   <!-- /.row -->
                   <div class=\"row\">
                       <div class=\"col-lg-3 col-md-6\">
                           <div class=\"panel panel-primary\">
                               <div class=\"panel-heading\">
                                   <div class=\"row\">
                                       <div class=\"col-xs-3\">
                                           <i class=\"fa fa-inbox fa-5x\"></i>
                                       </div>
                                       <div class=\"col-xs-9 text-right\">
                                           <div class=\"huge\">26 / 89</div>
                                           <div>Mesas cargadas</div>
                                       </div>
                                   </div>
                               </div>
                               <a href=\"#\">
                                   <div class=\"panel-footer\">
                                       <span class=\"pull-left\">Ver mas >></span>
                                       <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                       <div class=\"clearfix\"></div>
                                   </div>
                               </a>
                           </div>
                       </div>
                       <div class=\"col-lg-3 col-md-6\">
                           <div class=\"panel panel-green\">
                               <div class=\"panel-heading\">
                                   <div class=\"row\">
                                       <div class=\"col-xs-3\">
                                           <i class=\"fa fa-tasks fa-5x\"></i>
                                       </div>
                                       <div class=\"col-xs-9 text-right\">
                                           <div class=\"huge\">12 / 15</div>
                                           <div>Circuitos completados</div>
                                       </div>
                                   </div>
                               </div>
                               <a href=\"#\">
                                   <div class=\"panel-footer\">
                                       <span class=\"pull-left\">Detalles</span>
                                       <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                       <div class=\"clearfix\"></div>
                                   </div>
                               </a>
                           </div>
                       </div>
                       <div class=\"col-lg-3 col-md-6\">
                           <div class=\"panel panel-yellow\">
                               <div class=\"panel-heading\">
                                   <div class=\"row\">
                                       <div class=\"col-xs-3\">
                                           <i class=\"fa fa-cloud fa-5x\"></i>
                                       </div>
                                       <div class=\"col-xs-9 text-right\">
                                           <div class=\"huge\">25%</div>
                                           <div>Cargas online</div>
                                       </div>
                                   </div>
                               </div>
                               <a href=\"#\">
                                   <div class=\"panel-footer\">
                                       <span class=\"pull-left\">Lista completa</span>
                                       <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                       <div class=\"clearfix\"></div>
                                   </div>
                               </a>
                           </div>
                       </div>
                       <div class=\"col-lg-3 col-md-6\">
                           <div class=\"panel panel-red\">
                               <div class=\"panel-heading\">
                                   <div class=\"row\">
                                       <div class=\"col-xs-3\">
                                           <i class=\"fa fa-support fa-5x\"></i>
                                       </div>
                                       <div class=\"col-xs-9 text-right\">
                                           <div class=\"huge\">0</div>
                                           <div>Cargos provinciales</div>
                                       </div>
                                   </div>
                               </div>
                               <a href=\"#\">
                                   <div class=\"panel-footer\">
                                       <span class=\"pull-left\">Detalles</span>
                                       <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                       <div class=\"clearfix\"></div>
                                   </div>
                               </a>
                           </div>
                       </div>
                   </div>
                   <!-- /.row -->
                   <div class=\"row\">
                       <div class=\"col-lg-8\">
                           <div class=\"panel panel-default\">
                               <div class=\"panel-heading\">
                                   <i class=\"fa fa-bar-chart-o fa-fw\"></i> Area Chart Example
                                   <div class=\"pull-right\">
                                       <div class=\"btn-group\">
                                           <button type=\"button\" class=\"btn btn-default btn-xs dropdown-toggle\" data-toggle=\"dropdown\">
                                               Actions
                                               <span class=\"caret\"></span>
                                           </button>
                                           <ul class=\"dropdown-menu pull-right\" role=\"menu\">
                                               <li><a href=\"#\">Action</a>
                                               </li>
                                               <li><a href=\"#\">Another action</a>
                                               </li>
                                               <li><a href=\"#\">Something else here</a>
                                               </li>
                                               <li class=\"divider\"></li>
                                               <li><a href=\"#\">Separated link</a>
                                               </li>
                                           </ul>
                                       </div>
                                   </div>
                               </div>
                               <!-- /.panel-heading -->
                               <div class=\"panel-body\">
                                   <div id=\"morris-area-chart\"></div>
                               </div>
                               <!-- /.panel-body -->
                           </div>
                           <!-- /.panel -->
                           <div class=\"panel panel-default\">
                               <div class=\"panel-heading\">
                                   <i class=\"fa fa-bar-chart-o fa-fw\"></i> Bar Chart Example
                                   <div class=\"pull-right\">
                                       <div class=\"btn-group\">
                                           <button type=\"button\" class=\"btn btn-default btn-xs dropdown-toggle\" data-toggle=\"dropdown\">
                                               Actions
                                               <span class=\"caret\"></span>
                                           </button>
                                           <ul class=\"dropdown-menu pull-right\" role=\"menu\">
                                               <li><a href=\"#\">Action</a>
                                               </li>
                                               <li><a href=\"#\">Another action</a>
                                               </li>
                                               <li><a href=\"#\">Something else here</a>
                                               </li>
                                               <li class=\"divider\"></li>
                                               <li><a href=\"#\">Separated link</a>
                                               </li>
                                           </ul>
                                       </div>
                                   </div>
                               </div>
                               <!-- /.panel-heading -->
                               <div class=\"panel-body\">
                                   <div class=\"row\">
                                       <div class=\"col-lg-4\">
                                           <div class=\"table-responsive\">
                                               <table class=\"table table-bordered table-hover table-striped\">
                                                   <thead>
                                                       <tr>
                                                           <th>#</th>
                                                           <th>Date</th>
                                                           <th>Time</th>
                                                           <th>Amount</th>
                                                       </tr>
                                                   </thead>
                                                   <tbody>
                                                       <tr>
                                                           <td>3326</td>
                                                           <td>10/21/2013</td>
                                                           <td>3:29 PM</td>
                                                           <td>\$321.33</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3325</td>
                                                           <td>10/21/2013</td>
                                                           <td>3:20 PM</td>
                                                           <td>\$234.34</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3324</td>
                                                           <td>10/21/2013</td>
                                                           <td>3:03 PM</td>
                                                           <td>\$724.17</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3323</td>
                                                           <td>10/21/2013</td>
                                                           <td>3:00 PM</td>
                                                           <td>\$23.71</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3322</td>
                                                           <td>10/21/2013</td>
                                                           <td>2:49 PM</td>
                                                           <td>\$8345.23</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3321</td>
                                                           <td>10/21/2013</td>
                                                           <td>2:23 PM</td>
                                                           <td>\$245.12</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3320</td>
                                                           <td>10/21/2013</td>
                                                           <td>2:15 PM</td>
                                                           <td>\$5663.54</td>
                                                       </tr>
                                                       <tr>
                                                           <td>3319</td>
                                                           <td>10/21/2013</td>
                                                           <td>2:13 PM</td>
                                                           <td>\$943.45</td>
                                                       </tr>
                                                   </tbody>
                                               </table>
                                           </div>
                                           <!-- /.table-responsive -->
                                       </div>
                                       <!-- /.col-lg-4 (nested) -->
                                       <div class=\"col-lg-8\">
                                           <div id=\"morris-bar-chart\"></div>
                                       </div>
                                       <!-- /.col-lg-8 (nested) -->
                                   </div>
                                   <!-- /.row -->
                               </div>
                               <!-- /.panel-body -->
                           </div>

                       </div>
                       <!-- /.col-lg-8 -->
                       <div class=\"col-lg-4\">
                           <div class=\"panel panel-default\">
                               <div class=\"panel-heading\">
                                   <i class=\"fa fa-bell fa-fw\"></i> Notifications Panel
                               </div>
                               <!-- /.panel-heading -->
                               <div class=\"panel-body\">
                                   <div class=\"list-group\">
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-comment fa-fw\"></i> New Comment
                                           <span class=\"pull-right text-muted small\"><em>4 minutes ago</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-twitter fa-fw\"></i> 3 New Followers
                                           <span class=\"pull-right text-muted small\"><em>12 minutes ago</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-envelope fa-fw\"></i> Message Sent
                                           <span class=\"pull-right text-muted small\"><em>27 minutes ago</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-tasks fa-fw\"></i> New Task
                                           <span class=\"pull-right text-muted small\"><em>43 minutes ago</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-upload fa-fw\"></i> Server Rebooted
                                           <span class=\"pull-right text-muted small\"><em>11:32 AM</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-bolt fa-fw\"></i> Server Crashed!
                                           <span class=\"pull-right text-muted small\"><em>11:13 AM</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-warning fa-fw\"></i> Server Not Responding
                                           <span class=\"pull-right text-muted small\"><em>10:57 AM</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-shopping-cart fa-fw\"></i> New Order Placed
                                           <span class=\"pull-right text-muted small\"><em>9:49 AM</em>
                                           </span>
                                       </a>
                                       <a href=\"#\" class=\"list-group-item\">
                                           <i class=\"fa fa-money fa-fw\"></i> Payment Received
                                           <span class=\"pull-right text-muted small\"><em>Yesterday</em>
                                           </span>
                                       </a>
                                   </div>
                                   <!-- /.list-group -->
                                   <a href=\"#\" class=\"btn btn-default btn-block\">View All Alerts</a>
                               </div>
                               <!-- /.panel-body -->
                           </div>
                           <!-- /.panel -->
                           <div class=\"panel panel-default\">
                               <div class=\"panel-heading\">
                                   <i class=\"fa fa-bar-chart-o fa-fw\"></i> Donut Chart Example
                               </div>
                               <div class=\"panel-body\">
                                   <div id=\"morris-donut-chart\"></div>
                                   <a href=\"#\" class=\"btn btn-default btn-block\">View Details</a>
                               </div>
                               <!-- /.panel-body -->
                           </div>
                           <!-- /.panel -->
                           <div class=\"chat-panel panel panel-default\">
                               <div class=\"panel-heading\">
                                   <i class=\"fa fa-comments fa-fw\"></i> Chat
                                   <div class=\"btn-group pull-right\">
                                       <button type=\"button\" class=\"btn btn-default btn-xs dropdown-toggle\" data-toggle=\"dropdown\">
                                           <i class=\"fa fa-chevron-down\"></i>
                                       </button>
                                       <ul class=\"dropdown-menu slidedown\">
                                           <li>
                                               <a href=\"#\">
                                                   <i class=\"fa fa-refresh fa-fw\"></i> Refresh
                                               </a>
                                           </li>
                                           <li>
                                               <a href=\"#\">
                                                   <i class=\"fa fa-check-circle fa-fw\"></i> Available
                                               </a>
                                           </li>
                                           <li>
                                               <a href=\"#\">
                                                   <i class=\"fa fa-times fa-fw\"></i> Busy
                                               </a>
                                           </li>
                                           <li>
                                               <a href=\"#\">
                                                   <i class=\"fa fa-clock-o fa-fw\"></i> Away
                                               </a>
                                           </li>
                                           <li class=\"divider\"></li>
                                           <li>
                                               <a href=\"#\">
                                                   <i class=\"fa fa-sign-out fa-fw\"></i> Sign Out
                                               </a>
                                           </li>
                                       </ul>
                                   </div>
                               </div>
                               <!-- /.panel-heading -->
                               <div class=\"panel-body\">
                                   <ul class=\"chat\">
                                       <li class=\"left clearfix\">
                                           <span class=\"chat-img pull-left\">
                                               <img src=\"http://placehold.it/50/55C1E7/fff\" alt=\"User Avatar\" class=\"img-circle\" />
                                           </span>
                                           <div class=\"chat-body clearfix\">
                                               <div class=\"header\">
                                                   <strong class=\"primary-font\">Jack Sparrow</strong>
                                                   <small class=\"pull-right text-muted\">
                                                       <i class=\"fa fa-clock-o fa-fw\"></i> 12 mins ago
                                                   </small>
                                               </div>
                                               <p>
                                                   Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                               </p>
                                           </div>
                                       </li>
                                       <li class=\"right clearfix\">
                                           <span class=\"chat-img pull-right\">
                                               <img src=\"http://placehold.it/50/FA6F57/fff\" alt=\"User Avatar\" class=\"img-circle\" />
                                           </span>
                                           <div class=\"chat-body clearfix\">
                                               <div class=\"header\">
                                                   <small class=\" text-muted\">
                                                       <i class=\"fa fa-clock-o fa-fw\"></i> 13 mins ago</small>
                                                   <strong class=\"pull-right primary-font\">Bhaumik Patel</strong>
                                               </div>
                                               <p>
                                                   Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                               </p>
                                           </div>
                                       </li>
                                       <li class=\"left clearfix\">
                                           <span class=\"chat-img pull-left\">
                                               <img src=\"http://placehold.it/50/55C1E7/fff\" alt=\"User Avatar\" class=\"img-circle\" />
                                           </span>
                                           <div class=\"chat-body clearfix\">
                                               <div class=\"header\">
                                                   <strong class=\"primary-font\">Jack Sparrow</strong>
                                                   <small class=\"pull-right text-muted\">
                                                       <i class=\"fa fa-clock-o fa-fw\"></i> 14 mins ago</small>
                                               </div>
                                               <p>
                                                   Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                               </p>
                                           </div>
                                       </li>
                                       <li class=\"right clearfix\">
                                           <span class=\"chat-img pull-right\">
                                               <img src=\"http://placehold.it/50/FA6F57/fff\" alt=\"User Avatar\" class=\"img-circle\" />
                                           </span>
                                           <div class=\"chat-body clearfix\">
                                               <div class=\"header\">
                                                   <small class=\" text-muted\">
                                                       <i class=\"fa fa-clock-o fa-fw\"></i> 15 mins ago</small>
                                                   <strong class=\"pull-right primary-font\">Bhaumik Patel</strong>
                                               </div>
                                               <p>
                                                   Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                               </p>
                                           </div>
                                       </li>
                                   </ul>
                               </div>
                               <!-- /.panel-body -->
                               <div class=\"panel-footer\">
                                   <div class=\"input-group\">
                                       <input id=\"btn-input\" type=\"text\" class=\"form-control input-sm\" placeholder=\"Type your message here...\" />
                                       <span class=\"input-group-btn\">
                                           <button class=\"btn btn-warning btn-sm\" id=\"btn-chat\">
                                               Send
                                           </button>
                                       </span>
                                   </div>
                               </div>
                               <!-- /.panel-footer -->
                           </div>
                           <!-- /.panel .chat-panel -->
                       </div>
                       <!-- /.col-lg-4 -->
                   </div>
                   <!-- /.row -->
               </div>
               <!-- /#page-wrapper -->

           </div>
           <!-- /#wrapper -->
{% endblock %}
", "index.html.twig", "/var/www/elecciones/templates/index.html.twig");
    }
}