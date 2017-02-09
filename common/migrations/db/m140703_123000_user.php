<?php

use common\models\User;
use yii\db\Schema;
use yii\db\Migration;

class m140703_123000_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            //$tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT='用户主表'";
        }
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT='用户主表'";
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(32). " COMMENT '唯一登陆名'",
            'realname' => $this->string(32). " COMMENT '真实姓名'",
            'id_number' => $this->string(18). " COMMENT '唯一身份证号'",
            'phone_number' => $this->string(11). " COMMENT '唯一手机号'",
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(40)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'oauth_client' => $this->string(),
            'oauth_client_user_id' => $this->string(),
            'email' => $this->string()->notNull(). " COMMENT '唯一邮箱地址'",
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'source' => $this->smallInteger()->notNull()->defaultValue(0). " COMMENT '10：注册；20：邀请'",
            'safety' => $this->smallInteger()->notNull()->defaultValue(0). " COMMENT '安全等级：1：邮件验证；2：手机验证；4：身份证实名，全部验证是7'",
            'logged_ip' => $this->string(15). " COMMENT '最后登录IP'",
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'logged_at' => $this->integer()
        ], $tableOptions);

//$this->addColumn('{{%user}}', 'phone_number', $this->string);
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT='用户主表附表'";
        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->primaryKey(),
            'id_card_path' => $this->string(). " COMMENT '身份证正反照片'",
            'qq_number' => $this->string(32). " COMMENT '唯一QQ号'",
            'weixin_number' => $this->string(32). " COMMENT '唯一微信号'",
            'address' => $this->string(512)->notNull(). " COMMENT '详细邮寄地址'",
            'firstname' => $this->string(),
            'middlename' => $this->string(),
            'lastname' => $this->string(),
            'avatar_path' => $this->string(),
            'avatar_base_url' => $this->string(),
            'locale' => $this->string(32)->notNull()." COMMENT '页面显示语言'",
            'birth' => $this->integer(). " COMMENT '公历生日'",
            'gender' => $this->smallInteger(1). " COMMENT '2女，1男'"
        ], $tableOptions);

        $this->addForeignKey('fk_user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');

    }

    public function down()
    {
        $this->dropForeignKey('fk_user', '{{%user_profile}}');
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user}}');

    }
}
