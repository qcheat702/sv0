<?php

namespace sv\admin\models;


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

    //元数据规则
    public function metaRules()
    {
        return [
            [['article_category'], 'safe'],
        ];
    }
    //元数据标签
    public function metaLabels()
    {
        return [
            'article_category' => '文章类别',
        ];
    }

    /**
     * 获取元数据
     * @param  mixed[string/array] $metas 元数据键值/元数据键值序列
     * @return array/null        参数为字符串返回单一元数据/参数为元数据键值序列时返回以元数据键值为键值的元数据序列
    */
    public function getMetas($metas)
    {
        if(  empty($metas)  ) return null;
        //如果元数据键值是字符串
        if (  is_string($metas)  )
            return $this->getMeta($metas);
        //如果元数据键值是数组序列
        if(  is_array($metas)  )
        {
            $_arr = null;
            foreach ($metas as $km => $meta)
            {
                $_mata = $this->getMeta($meta);
                if(  !is_null($_mata)  )
                    $_arr[$meta] = $this->getMeta($meta);
            }
            return $_arr;
        }

        return null;
    }
    
    /**
     * 获取单个元数据
     * @param  string $meta 元数据键值
     * @return array/null   获取元数据
     */
    public function getMeta($meta)
    {
        $rules = $this->getMetaRules($meta);

        if(  is_null($rules)  )return null;

        return 
        [
            'key' => $meta,
            'label' => $this->getMataLabels($meta),
            'rules' => $rules
        ];
    }


    /**
     * 获取元数据规则
     * @param  string $meta_key 元数据键值
     * @return array/null 元数据规则数组,无效的键值会抛出错误
     */
    public function getMetaRules($meta_key)
    {
        $metarules = null;
        foreach ($this->metaRules() as $kr => $vr) 
        {
            foreach ($vr[0] as $km => $vm)
                if(  $meta_key == $vm  )
                    $metarules[$vr[1]][] = isset($vr[2])?$vr[2]:true;
        }

        if(  is_null($metarules)  )throw new ErrorException('无效的元数据键值:['.$meta_key.']'); 
        return $metarules;
    }



    /**
     * 获取元数据标签
     * @param  mixed[string/array] $metas 元数据键值或键值序列
     * @return mixed[string/array/null]        对应的元数据标签。元数据为字符串，返回其标签字符串，未定义标签则返回其本身；元数据为数组，则返回以其自身为键值的元数据标签序列
     */
    public function getMataLabels($metas)
    {

        if(  empty($metas)  )return null;

        //获取所有的元数据标签
        $metaLabels = $this->metaLabels();
        //如果参数是字符串
        if(  is_string($metas)  )
            return isset($metaLabels[$metas])?$metaLabels[$metas]:$metas;

        //如果参数是数组
        if(  is_array($metas)  )
        {
            $_arr = null;
            foreach ($metas as $key => $value)
                $_arr[$value] = isset($metaLabels[$metas])?$metaLabels[$metas]:$metas;            
            return $_arr;
        }

        return null;
    }

    /**
     * 元数据值编码
     * @param  mixed $data 数据
     * @return string  编码后的元数据值
     */
    public function encodeMetaValue($data)
    {
        return serialize($data);
    }

     /**
     * 元数据值解码
     * @param  string $data 数据
     * @return mixed  解码后的元数据值
     */
    public function decodeMetaValue($string)
    {
        return @unserialize($string);
    }
}
