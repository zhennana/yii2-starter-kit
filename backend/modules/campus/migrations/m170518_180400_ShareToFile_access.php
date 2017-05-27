<?php

use yii\db\Migration;

class m170518_180400_ShareToFile_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "campus_share-to-file_index",
            "description" => "campus/share-to-file/index"
        ],
        "view" => [
            "name" => "campus_share-to-file_view",
            "description" => "campus/share-to-file/view"
        ],
        "create" => [
            "name" => "campus_share-to-file_create",
            "description" => "campus/share-to-file/create"
        ],
        "update" => [
            "name" => "campus_share-to-file_update",
            "description" => "campus/share-to-file/update"
        ],
        "delete" => [
            "name" => "campus_share-to-file_delete",
            "description" => "campus/share-to-file/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "CampusShareToFileFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "CampusShareToFileView" => [
            "index",
            "view"
        ],
        "CampusShareToFileEdit" => [
            "update",
            "create",
            "delete"
        ]
    ];
    
    public function up()
    {
        
        $permisions = [];
        $auth = \Yii::$app->authManager;

        /**
         * create permisions for each controller action
         */
        foreach ($this->permisions as $action => $permission) {
            $permisions[$action] = $auth->createPermission($permission['name']);
            $permisions[$action]->description = $permission['description'];
            $auth->add($permisions[$action]);
        }

        /**
         *  create roles
         */
        foreach ($this->roles as $roleName => $actions) {
            $role = $auth->createRole($roleName);
            $auth->add($role);

            /**
             *  to role assign permissions
             */
            foreach ($actions as $action) {
                $auth->addChild($role, $permisions[$action]);
            }
        }
    }

    public function down() {
        $auth = Yii::$app->authManager;

        foreach ($this->roles as $roleName => $actions) {
            $role = $auth->createRole($roleName);
            $auth->remove($role);
        }

        foreach ($this->permisions as $permission) {
            $authItem = $auth->createPermission($permission['name']);
            $auth->remove($authItem);
        }
    }
}
