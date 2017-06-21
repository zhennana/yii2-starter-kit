<?php

use yii\db\Migration;

class m170527_114700_StudentRecordValue_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "campus_student-record-value_index",
            "description" => "campus/student-record-value/index"
        ],
        "view" => [
            "name" => "campus_student-record-value_view",
            "description" => "campus/student-record-value/view"
        ],
        "create" => [
            "name" => "campus_student-record-value_create",
            "description" => "campus/student-record-value/create"
        ],
        "update" => [
            "name" => "campus_student-record-value_update",
            "description" => "campus/student-record-value/update"
        ],
        "delete" => [
            "name" => "campus_student-record-value_delete",
            "description" => "campus/student-record-value/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "CampusStudentRecordValueFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "CampusStudentRecordValueView" => [
            "index",
            "view"
        ],
        "CampusStudentRecordValueEdit" => [
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
