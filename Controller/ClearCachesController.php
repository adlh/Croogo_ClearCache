<?php
/**
 * ClearCache
 *
 * PHP version 5
 *
 * @category ClearCache.Controller
 * @package  Croogo.ClearCache
 * @version  1.4, 1.5
 * @author   Lukas Marks <info@lumax-web.de>
 * @link     https://www.lumax-web.de
 */

App::uses('ClearCachesAppController', 'ClearCache.Controller');

class ClearCachesController extends ClearCachesAppController {

    // use the ClearCache.ClearCache Plugin.Model
    public $uses = array('ClearCache.ClearCache');

    public function admin_clear() {
        $failed = $this->ClearCache->delete();
        if (empty($failed)) {
            $this->Session->setFlash(
                __('Cache has been cleared.', true),
                'default', array('class' => 'success'));
        } else {
            $files = '<br />';
            foreach ($failed as $f) {
                $files .= $f . '<br />';
            }
            $this->Session->setFlash(
                __('The following files could not be deleted:', true) .
                $files, 'default', array('class' => 'error'));
        }
        $this->redirect(array('plugin'=>'extensions',
            'controller'=>'extensions_plugins', 'action'=>'index'));
    }
}
