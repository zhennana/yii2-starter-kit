<?php

use yii\db\Schema;
use yii\db\Migration;


class m140703_123803_article extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%article_category}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(1024)->notNull(),
            'title' => $this->string(512)->notNull(),
            'body' => $this->text(),
            'parent_id' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(1024)->notNull(). " COMMENT '标题转拼音'",
            'title' => $this->string(512)->notNull(),
            'body' => $this->text()->notNull(),
            'view' => $this->string(). " COMMENT '内容观点'",
            'category_id' => $this->integer(),
            'thumbnail_base_url' => $this->string(1024),
            'thumbnail_path' => $this->string(1024),
            'author_id' => $this->integer(),
            'updater_id' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0). " COMMENT '0：草稿；1：发布'",
            'display_type' => $this->smallInteger()->notNull()->defaultValue(0). " COMMENT '展示方式：不同数字表示不同展示方式'",
            'page_view' => $this->integer(). " COMMENT '浏览量'",
            'unique_visitors' => $this->integer(). " COMMENT '独立浏览量'",
            'collect_number' => $this->integer(). " COMMENT '收藏数'",
            'comment_number' => $this->integer(). " COMMENT '评论数'",
            'useless_number' => $this->integer(). " COMMENT '没有价值（帮助）数'",
            'page_rank' => $this->integer(). " COMMENT '页面全局排序'",
            'published_at' => $this->integer(). " COMMENT '发布时间'",
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%article_attachment}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'path' => $this->string()->notNull(),
            'base_url' => $this->string(),
            'type' => $this->string(),
            'size' => $this->integer(),
            'name' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0). " COMMENT '0：关闭；10：公开；20：私有'",
            'hash' => $this->string(32),
            'upload_ip' => $this->string(15),
            'created_at' => $this->integer()
        ]);

        $this->addForeignKey('fk_article_attachment_article', '{{%article_attachment}}', 'article_id', '{{%article}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_article_author', '{{%article}}', 'author_id', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_article_updater', '{{%article}}', 'updater_id', '{{%user}}', 'id', 'set null', 'cascade');
        $this->addForeignKey('fk_article_category', '{{%article}}', 'category_id', '{{%article_category}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_article_category_section', '{{%article_category}}', 'parent_id', '{{%article_category}}', 'id', 'cascade', 'cascade');

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_article_attachment_article', '{{%article_attachment}}');
        $this->dropForeignKey('fk_article_author', '{{%article}}');
        $this->dropForeignKey('fk_article_updater', '{{%article}}');
        $this->dropForeignKey('fk_article_category', '{{%article}}');
        $this->dropForeignKey('fk_article_category_section', '{{%article_category}}');

        $this->dropTable('{{%article_attachment}}');
        $this->dropTable('{{%article}}');
        $this->dropTable('{{%article_category}}');
    }
}
