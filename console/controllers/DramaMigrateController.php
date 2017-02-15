<?php
namespace console\controllers;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class DramaMigrateController extends \yii\console\controllers\MigrateController
{
    /**
     * Creates a new migration instance.
     * @param string $class the migration class name
     * @return \common\rbac\Migration the migration instance
     */
    protected function createMigration($class)
    {
        $file = $this->migrationPath . DIRECTORY_SEPARATOR . $class . '.php';
        //var_dump($this->migrationPath, DIRECTORY_SEPARATOR, $class); exit();
        // /yii2-starter-kit/common/migrations/wechat/
        require_once($file);

        return new $class();
    }
}
