<?php

use yii\db\Migration;
use common\models\User;

class m160419_091758_wechat_fans_all_tables extends Migration
{
    public function up()
    {
        // 微信公众号
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            //$tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT='用户主表'";
        }
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT='微信公众号主表'";
        $this->createTable('{{%wechat}}', [
            'wechat_id' => $this->primaryKey(),
            'title' => $this->string(64). " COMMENT '公众号名称'",
            'appid' => $this->string(50)->notNull(). " COMMENT 'AppID'",
            'secret' => $this->string(50)->notNull(). " COMMENT 'AppSecret'",
            'url' => $this->string(255). " COMMENT '微信服务访问URL'",
            'token' => $this->string(32). " COMMENT '微信服务访问验证token'",
            'encoding_aes_key' => $this->string(43)->notNull(). " COMMENT '消息加密秘钥EncodingAesKey'",
            
            'access_token' => $this->string(255)->notNull()->defaultValue(''). " COMMENT '访问微信服务验证token'",
            'account' => $this->string(32). " COMMENT '微信号'",
            'original' => $this->string(40)->notNull()->defaultValue('')." COMMENT '原始ID'",

            'avatar' => $this->string(255)->notNull(). " COMMENT '头像地址'",
            'qrcode' => $this->string(255)->notNull(). " COMMENT '二维码地址'",

            'store_id' => $this->integer()->notNull()->defaultValue(0). " COMMENT '所属店铺ID'",
            'type' => $this->smallInteger()->notNull()->defaultValue(0). " COMMENT '类型'",
            'status' => $this->smallInteger()->notNull()->defaultValue(0). " COMMENT '0无效；1有效'",
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);
/*
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT='微信公众号统计表'";
        $this->createTable('{{%wechat_statistics}}', [
            'wechat_id' => $this->primaryKey(),
            'level' => $this->text(64). " COMMENT '等级'",
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);

        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT='微信公众号附属表'";
        $this->createTable('{{%wechat_profile}}', [
            'wechat_id' => $this->primaryKey(),
            'menu' => $this->text(64). " COMMENT '按钮'",
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);
*/
        $this->insert('{{%wechat}}', [
            'wechat_id' => 1,
            'title' => '燕郊在线生活服务平台',
            'appid'     => 'wxf7bb08ab08e7119e',
            'secret'    => 'f87062eddea7ce3bd987d4efbe7186a9',
            'url' => 'http://home.yajol.com/index.php?r=wechat/api/index&wechat_id=1',
            'token' => 'ABkBBL8Sqzl7gE4FJ4zS',
            'encoding_aes_key' =>'IUnFuycJzSiTpBMuIxsXVeeOVuCEZTREZyBAoILEIvb',
            'access_token' => '',
            'account'   => 'yj__online',
            'original'   => 'gh_e31b8ecf2e6e',
            'status' => \common\models\wechat\base\Wechat::STATUS_ACTIVE,
            'created_at' => time()
        ]);

        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT='微信公众号粉丝表'";
        $this->createTable('{{%wechat_fans}}', [
            'fans_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(0),
            'wechat_id' => $this->integer(),
            'open_id' => $this->string(50). " COMMENT '微信open_id'",
            'status' => $this->smallInteger()->notNull()->defaultValue(0). " COMMENT '关注状态：0默认；1：关注 2：取消关注'",
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);
        $this->createIndex('idx_user_id', '{{%wechat_fans}}', ['user_id']);
        $this->createIndex('idx_open_id', '{{%wechat_fans}}', ['open_id']);
        $this->createIndex('idx_wechat_id', '{{%wechat_fans}}', ['wechat_id']);

//$this->addColumn('{{%user}}', 'phone_number', $this->string);
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT='微信公众号粉丝附属表'";
        $this->createTable('{{%wechat_fans_mp}}', [
            'fans_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(0),
            'nickname' => $this->string(). " COMMENT '身份证正反照片'",
            'city' => $this->string(32). " COMMENT '城市区域'",
            'country' => $this->string(512)->notNull(). " COMMENT '国家'",
            'province' => $this->string()." COMMENT '省份'",
            'language' => $this->string(40)." COMMENT '用户语言'",
            'union_id' => $this->string(30)." COMMENT '备注'",
            'remark' => $this->string(255)." COMMENT '备注'",
            'sex' => $this->smallInteger(0). " COMMENT '性别 1男 2女'",
            'group_id' => $this->smallInteger(1)->notNull()." COMMENT '分组ID'",
            'avatar' => $this->string(255)." COMMENT '用户头像'",
            'subscribe_time' => $this->integer('11')." COMMENT '关注时间'",
            'updated_at' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('fk_wechat_fans', '{{%wechat_fans_mp}}', 'fans_id', '{{%wechat_fans}}', 'fans_id', 'cascade', 'cascade');
    }

    public function down()
    {
        echo "m160419_091758_wechat_fans_all_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
