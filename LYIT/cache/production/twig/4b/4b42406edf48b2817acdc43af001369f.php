<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* login_forum.html */
class __TwigTemplate_91a51b3399c377f5259a42448ccbffe2 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        $location = "overall_header.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("overall_header.html", "login_forum.html", 1)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
        // line 2
        echo "
";
        // line 3
        if (($context["FORUM_NAME"] ?? null)) {
            echo "<h2 class=\"forum-title\"><a href=\"";
            echo ($context["U_VIEW_FORUM"] ?? null);
            echo "\">";
            echo ($context["FORUM_NAME"] ?? null);
            echo "</a></h2>";
        }
        // line 4
        echo "
<form id=\"login_forum\" method=\"post\" action=\"";
        // line 5
        echo ($context["S_LOGIN_ACTION"] ?? null);
        echo "\">
";
        // line 6
        echo ($context["S_FORM_TOKEN"] ?? null);
        echo "
<div class=\"panel\">
\t<div class=\"inner\">

\t<div class=\"content\">
\t\t<h2 class=\"login-title\">";
        // line 11
        echo $this->extensions['phpbb\template\twig\extension']->lang("LOGIN");
        echo "</h2>

\t\t<p>";
        // line 13
        echo $this->extensions['phpbb\template\twig\extension']->lang("LOGIN_FORUM");
        echo "</p>

\t\t<fieldset class=\"fields1\">
\t\t\t";
        // line 16
        if (($context["LOGIN_ERROR"] ?? null)) {
            // line 17
            echo "\t\t\t\t<dl>
\t\t\t\t\t<dt>&nbsp;</dt>
\t\t\t\t\t<dd class=\"error\">";
            // line 19
            echo ($context["LOGIN_ERROR"] ?? null);
            echo "</dd>
\t\t\t\t</dl>
\t\t\t";
        }
        // line 22
        echo "
\t\t\t<dl>
\t\t\t\t<dt><label for=\"password\">";
        // line 24
        echo $this->extensions['phpbb\template\twig\extension']->lang("PASSWORD");
        echo $this->extensions['phpbb\template\twig\extension']->lang("COLON");
        echo "</label></dt>
\t\t\t\t<dd><input type=\"password\" tabindex=\"1\" id=\"password\" name=\"password\" size=\"25\" class=\"inputbox narrow\" autocomplete=\"off\" /></dd>
\t\t\t</dl>
\t\t\t";
        // line 27
        echo ($context["S_LOGIN_REDIRECT"] ?? null);
        echo "
\t\t\t";
        // line 28
        echo ($context["S_FORM_TOKEN_LOGIN"] ?? null);
        echo "
\t\t\t<dl>
\t\t\t\t<dt>&nbsp;</dt>
\t\t\t\t<dd>";
        // line 31
        echo ($context["S_HIDDEN_FIELDS"] ?? null);
        echo "<input type=\"submit\" name=\"login\" id=\"login\" class=\"button1\" value=\"";
        echo $this->extensions['phpbb\template\twig\extension']->lang("LOGIN");
        echo "\" tabindex=\"2\" /></dd>
\t\t\t</dl>
\t\t</fieldset>
\t</div>

\t</div>
</div>

</form>

";
        // line 41
        $location = "jumpbox.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("jumpbox.html", "login_forum.html", 41)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
        // line 42
        $location = "overall_footer.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("overall_footer.html", "login_forum.html", 42)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
    }

    public function getTemplateName()
    {
        return "login_forum.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  146 => 42,  134 => 41,  119 => 31,  113 => 28,  109 => 27,  102 => 24,  98 => 22,  92 => 19,  88 => 17,  86 => 16,  80 => 13,  75 => 11,  67 => 6,  63 => 5,  60 => 4,  52 => 3,  49 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "login_forum.html", "");
    }
}
