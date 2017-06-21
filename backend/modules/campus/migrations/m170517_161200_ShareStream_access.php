<?php

use yii\db\Migration;

class m170517_161200_ShareStream_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "campus_share-stream_index",
            "description" => "campus/share-stream/index"
        ],
        "view" => [
            "name" => "campus_share-stream_view",
            "description" => "campus/share-stream/view"
        ],
        "create" => [
            "name" => "campus_share-stream_create",
            "description" => "campus/share-stream/create"
        ],
        "update" => [
            "name" => "campus_share-stream_update",
            "description" => "campus/share-stream/update"
        ],
        "delete" => [
            "name" => "campus_share-stream_delete",
            "description" => "campus/share-stream/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "CampusShareStreamFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "CampusShareStreamView" => [
            "index",
            "view"
        ],
        "CampusShareStreamEdit" => [
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
