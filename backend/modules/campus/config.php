<?php
	return [
//扩展组件
		 'components'=>[
		 
		 		'campus'=>[
		 			'class'=>'yii\db\Connection',
                	'dsn' => env('DB_DSN_CAMPUS'),
	                'username' => env('DB_USERNAME_CAMPUS'),
	                'password' => env('DB_PASSWORD_CAMPUS'),
	                'tablePrefix' => env('DB_TABLE_PREFIX_CAMPUS'),
	                'charset' => 'utf8',
	                'enableSchemaCache' => YII_ENV_PROD,
		 		]
			/*	'view' => [
					 'theme' => [
					     'basePath' => '@frontend/themes/'.env('THEME'),
					    'baseUrl' => '@frontend/themes/'.env('THEME'),
					     'pathMap' => [
					         '@backend/campus/views' => '@app/themes/'.env('THEME'),
					         '@frontend/views' => '@app/themes/basic',
					         '@frontend/views' => '@app/themes/edu',
					        //'@frontend/views' => '@app/themes/react',
					    ],
					],
				],
		*/
        ],

		//模块数组
       'params'=>[],
	];
?>