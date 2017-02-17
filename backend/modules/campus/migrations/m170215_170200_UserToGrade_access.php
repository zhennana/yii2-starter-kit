<?php

use yii\db\Migration;

class m170215_170200_UserToGrade_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "campus_user-to-grade_index",
            "description" => "campus/user-to-grade/index"
        ],
        "view" => [
            "name" => "campus_user-to-grade_view",
            "description" => "campus/user-to-grade/view"
        ],
        "create" => [
            "name" => "campus_user-to-grade_create",
            "description" => "campus/user-to-grade/create"
        ],
        "update" => [
            "name" => "campus_user-to-grade_update",
            "description" => "campus/user-to-grade/update"
        ],
        "delete" => [
            "name" => "campus_user-to-grade_delete",
            "description" => "campus/user-to-grade/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "CampusUserToGradeFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "CampusUserToGradeView" => [
            "index",
            "view"
        ],
        "CampusUserToGradeEdit" => [
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
