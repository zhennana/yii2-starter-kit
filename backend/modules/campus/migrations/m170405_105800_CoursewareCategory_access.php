<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/06167e2fb02cc14038b930dff6e6a104
 *
 * @package default
 */


use yii\db\Migration;

class m170405_105800_CoursewareCategory_access extends Migration
{

	/**
	 *
	 * @var array controller all actions
	 */
	public $permisions = [
		"index" => [
			"name" => "campus_courseware-category_index",
			"description" => "campus/courseware-category/index"
		],
		"view" => [
			"name" => "campus_courseware-category_view",
			"description" => "campus/courseware-category/view"
		],
		"create" => [
			"name" => "campus_courseware-category_create",
			"description" => "campus/courseware-category/create"
		],
		"update" => [
			"name" => "campus_courseware-category_update",
			"description" => "campus/courseware-category/update"
		],
		"delete" => [
			"name" => "campus_courseware-category_delete",
			"description" => "campus/courseware-category/delete"
		]
	];



	/**
	 *
	 * @var array roles and maping to actions/permisions
	 */
	public $roles = [
		"CampusCoursewareCategoryFull" => [
			"index",
			"view",
			"create",
			"update",
			"delete"
		],
		"CampusCoursewareCategoryView" => [
			"index",
			"view"
		],
		"CampusCoursewareCategoryEdit" => [
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
