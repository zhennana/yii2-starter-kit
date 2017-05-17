<?php

use yii\db\Migration;

class m170517_140600_Notice_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "campus_notice_index",
            "description" => "campus/notice/index"
        ],
        "view" => [
            "name" => "campus_notice_view",
            "description" => "campus/notice/view"
        ],
        "create" => [
            "name" => "campus_notice_create",
            "description" => "campus/notice/create"
        ],
        "update" => [
            "name" => "campus_notice_update",
            "description" => "campus/notice/update"
        ],
        "delete" => [
            "name" => "campus_notice_delete",
            "description" => "campus/notice/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "CampusNoticeFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "CampusNoticeView" => [
            "index",
            "view"
        ],
        "CampusNoticeEdit" => [
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
