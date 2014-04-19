<?php
/**
 * ClearCache
 *
 * PHP version 5
 *
 * @category ClearCache.Model
 * @package  Croogo.ClearCache
 * @version  1.4, 1.5
 * @author   Lukas Marks <info@lumax-web.de>
 * @link     https://www.lumax-web.de
 */
App::uses('ClearCacheAppModel', 'ClearCache.Model');

class ClearCache extends ClearCacheAppModel {

    public $name = 'ClearCache';
    public $useTable = false;

    public function delete($path = null, $recursive = true, $failed = array()) {
        if (!$path) {
            $path = TMP . 'cache' . DS;
        }

        $dirItems = scandir($path);
        $ignore = array('.', '..');
        foreach ($dirItems AS $dirItem) {
            if (in_array($dirItem, $ignore)) {
                continue;
            }

            if (is_dir($path . $dirItem) && $recursive) {
                $failed = $this->delete($path . $dirItem . DS, true, $failed);
            } elseif (
                (substr($dirItem, 0, 5) == 'cake_') ||
                (substr($dirItem, 0, 5) == 'type_') ||
                (substr($dirItem, 0, 5) == 'node_') ||
                (substr($dirItem, 0, 6) == 'nodes_') ||
                (substr($dirItem, 0, 7) == 'croogo_') ||
                (substr($dirItem, 0, 12) == 'permissions_')) {
                    $deleted = false;
                    try {
                        $deleted = unlink($path . $dirItem);
                    } catch (Exception $e) {
                        $deleted = false;
                    }
                    if (!$deleted) {
                        $failed[] = $dirItem;
                        //CakeLog::write('debug',
                            //'Could not delete: ' . $path . $dirItem);
                }
            }
        }
        return $failed;
    }
}
