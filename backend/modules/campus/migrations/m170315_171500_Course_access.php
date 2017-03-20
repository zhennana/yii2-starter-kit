<?php

use yii\db\Migration;

class m170315_171500_Course_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "campus_course_index",
            "description" => "campus/course/index"
        ],
        "view" => [
            "name" => "campus_course_view",
            "description" => "campus/course/view"
        ],
        "create" => [
            "name" => "campus_course_create",
            "description" => "campus/course/create"
        ],
        "update" => [
            "name" => "campus_course_update",
            "description" => "campus/course/update"
        ],
        "delete" => [
            "name" => "campus_course_delete",
            "description" => "campus/course/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "CampusCourseFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "CampusCourseView" => [
            "index",
            "view"
        ],
        "CampusCourseEdit" => [
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
