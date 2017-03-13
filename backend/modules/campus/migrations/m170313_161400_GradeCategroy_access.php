<?php

use yii\db\Migration;

class m170313_161400_GradeCategroy_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "campus_grade-categroy_index",
            "description" => "campus/grade-categroy/index"
        ],
        "view" => [
            "name" => "campus_grade-categroy_view",
            "description" => "campus/grade-categroy/view"
        ],
        "create" => [
            "name" => "campus_grade-categroy_create",
            "description" => "campus/grade-categroy/create"
        ],
        "update" => [
            "name" => "campus_grade-categroy_update",
            "description" => "campus/grade-categroy/update"
        ],
        "delete" => [
            "name" => "campus_grade-categroy_delete",
            "description" => "campus/grade-categroy/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "CampusGradeCategroyFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "CampusGradeCategroyView" => [
            "index",
            "view"
        ],
        "CampusGradeCategroyEdit" => [
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
