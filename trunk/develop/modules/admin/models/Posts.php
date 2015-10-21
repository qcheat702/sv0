<?php

namespace sv\admin\models;

use Yii;

/**
 * This is the model class for table "{{%posts}}".
 *
 * @property string $ID
 * @property string $post_author
 * @property integer $post_date
 * @property integer $post_date_gmt
 * @property string $post_content
 * @property string $post_title
 * @property string $post_excerpt
 * @property string $post_status
 * @property string $comment_status
 * @property string $ping_status
 * @property string $post_password
 * @property string $post_name
 * @property string $to_ping
 * @property string $pinged
 * @property integer $post_modified
 * @property integer $post_modified_gmt
 * @property string $post_content_filtered
 * @property string $post_parent
 * @property string $guid
 * @property integer $menu_order
 * @property string $post_type
 * @property integer $comment_count
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%posts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_author', 'post_date', 'post_date_gmt', 'post_modified', 'post_modified_gmt', 'post_parent', 'menu_order', 'comment_count'], 'integer'],
            [['post_content', 'post_title'], 'required'],
            [['post_content', 'post_title', 'post_excerpt', 'to_ping', 'pinged', 'post_content_filtered'], 'string'],
            [['post_status', 'comment_status', 'ping_status', 'post_password', 'post_type'], 'string', 'max' => 20],
            [['post_name'], 'string', 'max' => 200],
            [['guid'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'post_author' => '作者',
            'post_date' => '日期',
            'post_date_gmt' => '创建日期Gmt',
            'post_content' => '内容',
            'post_title' => '标题',
            'post_excerpt' => '摘要',
            'post_status' => '状态',
            'comment_status' => '评论状态',
            'ping_status' => 'Ping',
            'post_password' => '怒那',
            'post_name' => 'Post Name',
            'to_ping' => 'To Ping',
            'pinged' => 'Pinged',
            'post_modified' => '最后修改时间',
            'post_modified_gmt' => '最后修改时间Gmt',
            'post_content_filtered' => 'Post Content Filtered',
            'post_parent' => 'Post Parent',
            'guid' => 'Guid',
            'menu_order' => 'Menu Order',
            'post_type' => 'Post Type',
            'comment_count' => '评论计数',
        ];
    }

    public function getMeta(){
        return $this->hasMany(Postmeta::className(), ['ID' => 'post_id']);
    }
}
