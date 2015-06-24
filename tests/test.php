<?php
error_reporting(-1);
ini_set("display_errors", 1);
ini_set('error_reporting', -1);
error_log("handle_misc_edits is running in debug mode!");
?>
<!doctype html>
<html>
  <head>
    <title>
      PHP Core tests
    </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
  </head>
  <body>
      <div class='page-header'><h1>PHP Core tests</h1></div>
    <?php
       require_once("../core.php");
       echo "All is well in load-land.<br/>";
?>
<p>Beginning tests</p>
<?php
# Markdown
echo "<section class='panel panel-primary'><div class='panel-heading'>Markdown Tests</div>"
$text = "Here is some **Markdown** text that I *really* want to parse. What about [b]Classic options[/b]?";
echo "<code>$text</code><br/>";
$html = Wysiwyg::toHtml($text);
echo "<div class='bg-success'>$html</div>"
echo "<br/>Returns: <div class='bg-success'><code>" . Wysiwyg::fromHtml($html) . "</code></div>";
echo "</section>"
       ?>
  </body>
</html>
