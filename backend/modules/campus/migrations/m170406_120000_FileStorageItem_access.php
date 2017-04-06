<?php

use yii\db\Migration;

class m170406_120000_FileStorageItem_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "campus_file-storage-item_index",
            "description" => "campus/file-storage-item/index"
        ],
        "view" => [
            "name" => "campus_file-storage-item_view",
            "description" => "campus/file-storage-item/view"
        ],
        "create" => [
            "name" => "campus_file-storage-item_create",
            "description" => "campus/file-storage-item/create"
        ],
        "update" => [
            "name" => "campus_file-storage-item_update",
            "description" => "campus/file-storage-item/update"
        ],
        "delete" => [
            "name" => "campus_file-storage-item_delete",
            "description" => "campus/file-storage-item/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "CampusFileStorageItemFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "CampusFileStorageItemView" => [
            "index",
            "view"
        ],
        "CampusFileStorageItemEdit" => [
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
