<?php
/**
 * DokuWiki Plugin feedauth (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Andreas Gohr <andi@splitbrain.org>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'action.php';

class action_plugin_feedauth extends DokuWiki_Action_Plugin {

    function register(&$controller) {

       $controller->register_hook('FEED_OPTS_POSTPROCESS', 'BEFORE', $this, 'handle_feed_opts_postprocess');

    }

    function handle_feed_opts_postprocess(&$event, $param) {
        if(!$_SERVER['REMOTE_USER']){
            if($this->getConfig('always') || isset($_REQUEST['feedauth'])){
                header('WWW-Authenticate: Basic realm="Feed"');
                header('HTTP/1.0 401 Unauthorized');
                echo 'Authorization required';
                exit;
            }
        }
    }

}

// vim:ts=4:sw=4:et:enc=utf-8:
