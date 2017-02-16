<?php

use yii\db\Migration;

class m170215_160900_StudentRecord_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "campus_student-record_index",
            "description" => "campus/student-record/index"
        ],
        "view" => [
            "name" => "campus_student-record_view",
            "description" => "campus/student-record/view"
        ],
        "create" => [
            "name" => "campus_student-record_create",
            "description" => "campus/student-record/create"
        ],
        "update" => [
            "name" => "campus_student-record_update",
            "description" => "campus/student-record/update"
        ],
        "delete" => [
            "name" => "campus_student-record_delete",
            "description" => "campus/student-record/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "CampusStudentRecordFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "CampusStudentRecordView" => [
            "index",
            "view"
        ],
        "CampusStudentRecordEdit" => [
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
