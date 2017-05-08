<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/06167e2fb02cc14038b930dff6e6a104
 *
 * @package default
 */


use yii\db\Migration;

class m170505_134000_UserToken_access extends Migration
{

	/**
	 *
	 * @var array controller all actions
	 */
	public $permisions = [
		"index" => [
			"name" => "backend_user-token_index",
			"description" => "backend/user-token/index"
		],
		"view" => [
			"name" => "backend_user-token_view",
			"description" => "backend/user-token/view"
		],
		"create" => [
			"name" => "backend_user-token_create",
			"description" => "backend/user-token/create"
		],
		"update" => [
			"name" => "backend_user-token_update",
			"description" => "backend/user-token/update"
		],
		"delete" => [
			"name" => "backend_user-token_delete",
			"description" => "backend/user-token/delete"
		]
	];



	/**
	 *
	 * @var array roles and maping to actions/permisions
	 */
	public $roles = [
		"BackendUserTokenFull" => [
			"index",
			"view",
			"create",
			"update",
			"delete"
		],
		"BackendUserTokenView" => [
			"index",
			"view"
		],
		"BackendUserTokenEdit" => [
			"update",
			"create",
			"delete"
		]
	];



	/**
	 *
	 */
	public function up() {

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


	/**
	 *
	 */
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
