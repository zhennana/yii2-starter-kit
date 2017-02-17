<?php

use yii\db\Migration;

class m170215_161600_Courseware_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "campus_courseware_index",
            "description" => "campus/courseware/index"
        ],
        "view" => [
            "name" => "campus_courseware_view",
            "description" => "campus/courseware/view"
        ],
        "create" => [
            "name" => "campus_courseware_create",
            "description" => "campus/courseware/create"
        ],
        "update" => [
            "name" => "campus_courseware_update",
            "description" => "campus/courseware/update"
        ],
        "delete" => [
            "name" => "campus_courseware_delete",
            "description" => "campus/courseware/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "CampusCoursewareFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "CampusCoursewareView" => [
            "index",
            "view"
        ],
        "CampusCoursewareEdit" => [
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
