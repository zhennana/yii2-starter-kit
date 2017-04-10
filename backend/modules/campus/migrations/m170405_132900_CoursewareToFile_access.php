<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/06167e2fb02cc14038b930dff6e6a104
 *
 * @package default
 */


use yii\db\Migration;

class m170405_132900_CoursewareToFile_access extends Migration
{

	/**
	 *
	 * @var array controller all actions
	 */
	public $permisions = [
		"index" => [
			"name" => "campus_courseware-to-file_index",
			"description" => "campus/courseware-to-file/index"
		],
		"view" => [
			"name" => "campus_courseware-to-file_view",
			"description" => "campus/courseware-to-file/view"
		],
		"create" => [
			"name" => "campus_courseware-to-file_create",
			"description" => "campus/courseware-to-file/create"
		],
		"update" => [
			"name" => "campus_courseware-to-file_update",
			"description" => "campus/courseware-to-file/update"
		],
		"delete" => [
			"name" => "campus_courseware-to-file_delete",
			"description" => "campus/courseware-to-file/delete"
		]
	];



	/**
	 *
	 * @var array roles and maping to actions/permisions
	 */
	public $roles = [
		"CampusCoursewareToFileFull" => [
			"index",
			"view",
			"create",
			"update",
			"delete"
		],
		"CampusCoursewareToFileView" => [
			"index",
			"view"
		],
		"CampusCoursewareToFileEdit" => [
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
