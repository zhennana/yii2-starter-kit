<?php

use yii\db\Schema;
use yii\db\Migration;

class m150318_213934_file_storage_item extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT='文件系统'";
        }

        $this->createTable('{{%file_storage_item}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()." COMMENT '上传者'",
            'component' => $this->string()->notNull()." COMMENT 'yajol-activity-attachment；yajol-article-attachment；'",
            'base_url' => $this->string(1024)->notNull(),
            'path' => $this->string(1024)->notNull(),
            'type' => $this->string(),
            'size' => $this->integer(),
            'name' => $this->string()." COMMENT '客户端文件名'",
            'upload_ip' => $this->string(15),
            'hash' => $this->string(32),
            'status' => $this->smallInteger()->notNull()->defaultValue(1). " COMMENT '0：关闭；10：公开；20：私有'",
            'source_type' => $this->smallInteger()->notNull()->defaultValue(0). " COMMENT '来源类型0：默认公共；1：活动；2：文章；'",
            'entity_id' => $this->integer()->notNull()->defaultValue(0)." COMMENT '实体ID，参考来源类型'",
            'page_view' => $this->integer()->notNull()->defaultValue(0)." COMMENT '预览量'",
            'sort_rank' => $this->smallInteger()->notNull()->defaultValue(0)." COMMENT '排序分值'",
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%file_storage_item_comments}}', [
            'comment_id' => $this->primaryKey(),
            'comment_parent_id' => $this->integer()->notNull()." COMMENT '评论父ID'",
            'file_storage_item_id' => $this->integer()->notNull()." COMMENT '文件ID'",
            'author_id' => $this->integer()->notNull()." COMMENT '评论作者ID'",
            'content' => $this->string(255)->notNull(). " COMMENT '评论内容'",
            'agent' => $this->string(255)->notNull(). " COMMENT '评论者的USER AGENT'",
            'status' => $this->smallInteger()->notNull()->defaultValue(1). " COMMENT '0：关闭；1：发布'",
            'ip' => $this->string(15),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);

        /*
        $this->createTable('{{%file_storage_item}}', [
            'id' => $this->primaryKey(),
            'component' => $this->string()->notNull(),
            'base_url' => $this->string(1024)->notNull(),
            'path' => $this->string(1024)->notNull(),
            'type' => $this->string(),
            'size' => $this->integer(),
            'name' => $this->string(),
            'upload_ip' => $this->string(15),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);
         */
    }
    public function down()
    {
        $this->dropTable('{{%file_storage_item}}');
    }
}
