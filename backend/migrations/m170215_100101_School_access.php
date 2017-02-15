<?php

use yii\db\Migration;

class m170215_100101_School_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "backend_school_index",
            "description" => "backend/school/index"
        ],
        "view" => [
            "name" => "backend_school_view",
            "description" => "backend/school/view"
        ],
        "create" => [
            "name" => "backend_school_create",
            "description" => "backend/school/create"
        ],
        "update" => [
            "name" => "backend_school_update",
            "description" => "backend/school/update"
        ],
        "delete" => [
            "name" => "backend_school_delete",
            "description" => "backend/school/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "BackendSchoolFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "BackendSchoolView" => [
            "index",
            "view"
        ],
        "BackendSchoolEdit" => [
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
