<?php

use yii\db\Migration;

class m170215_110101_StudentRecordItem_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "backend_student-record-item_index",
            "description" => "backend/student-record-item/index"
        ],
        "view" => [
            "name" => "backend_student-record-item_view",
            "description" => "backend/student-record-item/view"
        ],
        "create" => [
            "name" => "backend_student-record-item_create",
            "description" => "backend/student-record-item/create"
        ],
        "update" => [
            "name" => "backend_student-record-item_update",
            "description" => "backend/student-record-item/update"
        ],
        "delete" => [
            "name" => "backend_student-record-item_delete",
            "description" => "backend/student-record-item/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "BackendStudentRecordItemFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "BackendStudentRecordItemView" => [
            "index",
            "view"
        ],
        "BackendStudentRecordItemEdit" => [
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
