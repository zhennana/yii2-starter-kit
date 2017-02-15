<?php

use yii\db\Migration;

class m170215_140101_School_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "campus_school_index",
            "description" => "campus/school/index"
        ],
        "view" => [
            "name" => "campus_school_view",
            "description" => "campus/school/view"
        ],
        "create" => [
            "name" => "campus_school_create",
            "description" => "campus/school/create"
        ],
        "update" => [
            "name" => "campus_school_update",
            "description" => "campus/school/update"
        ],
        "delete" => [
            "name" => "campus_school_delete",
            "description" => "campus/school/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "CampusSchoolFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "CampusSchoolView" => [
            "index",
            "view"
        ],
        "CampusSchoolEdit" => [
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
