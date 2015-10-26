<?php

namespace sv\article\models;


use Yii;
use yii\base\ErrorException;

/**
 * This is the model class for table "{{%postmeta}}".
 *
 * @property string $meta_id
 * @property string $post_id
 * @property string $meta_key
 * @property string $meta_value
 */
class Postmeta extends \yii\db\ActiveRecord
{

    public static function tableName(){return '{{%postmeta}}';}

    public function rules()
    {
        return [
            [['post_id'], 'integer'],
            [['meta_value'], 'string'],
            [['meta_key'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'meta_id' => 'Meta ID',
            'post_id' => 'Post ID',
            'meta_key' => 'Meta Key',
            'meta_value' => 'Meta Value',
        ];
    }  


}
