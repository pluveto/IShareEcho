<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 分享插件（含二维码）。
 *
 * @package IShareEcho
 * @author  pluvet
 * @version 1.0.0
 * @link https://www.pluvet.com
 */
class IShareEcho_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @throws Typecho_Db_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array(__CLASS__, 'renderJs');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @access public
     * @return void
     */
    public static function deactivate()
    { }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    { }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    { }

    public static function renderJs($text, $widget)
    {
        ob_start();
        $widget->excerpt(80, '...');
        $excerpt = ob_get_clean();

        $assetsDir = Helper::options()->pluginUrl . '/IShareEcho/assets';
        $jsfile = $assetsDir . "/share.min.js";
        $cssfile = $assetsDir . "/share.min.css";
        $fontfile = $assetsDir ."/css/fontello.css";

        $text.=

<<<EOF
        <link rel="stylesheet" href="$fontfile">
        <link type="text/css" rel="stylesheet" href="$cssfile" />
        <script href="javascript:;" type="text/javascript" src="$jsfile"></script>    
        <script>
            window.onload = function() {
                var el = document.getElementById('share-area');
    
                var links = [{
                    plugin: 'wechat'
                },{
                    plugin: 'qrcode'
                },{
                    plugin: 'weibo'
                },{
                    plugin: 'github'
                }];
                var options = {
                    size: 'xs'
                };
                window.socialShare(el, links, options);
            }
        </script>    
EOF;

return $text;

    

}

public static function renderHtml()
{
    ?>
<div id="share-area"></div>
<?php
}
}
