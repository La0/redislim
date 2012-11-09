<?php

//Thanks to Josh Anyan
// http://stackoverflow.com/questions/7017755/sub-views-layouts-templates-in-slim-php-framework
class LayoutView extends \Slim\View
{
  static protected $layout = NULL;

  public static function set_layout($layout=NULL) {
    self::$layout = $layout;
  }

  public function render( $template ) {
    extract($this->data);
    $templatePath = $this->getTemplatesDirectory() . '/' . ltrim($template, '/');
    if ( !file_exists($templatePath) )
      throw new RuntimeException('View cannot render template `' . $templatePath . '`. Template does not exist.');

    ob_start();
    require $templatePath;
    $html = ob_get_clean();
    return $this->render_layout($html);
  }

  public function render_layout($html) {
    if(self::$layout !== NULL)
    {
      $layout_path = $this->getTemplatesDirectory() . '/' . ltrim(self::$layout, '/');
      if ( !file_exists($layout_path) ) {
          throw new RuntimeException('View cannot render layout `' . $layout_path . '`. Layout does not exist.');
      }
      ob_start();
      require $layout_path;
      $html = ob_get_clean();
    }
    return $html;
  }

}
