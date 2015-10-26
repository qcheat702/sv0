<?php

namespace sv\article\models;

use Yii;
use yii\base\ErrorException;

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
    //元数据AR数组序列
    public $_metas = null;
    
    public static function tableName(){return '{{%posts}}';}

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

    public function attributeLabels()
    {
        return [
            'ID'                    => 'ID',
            'post_author'           => '作者',
            'post_date'             => '日期',
            'post_date_gmt'         => '创建日期Gmt',
            'post_content'          => '内容',
            'post_title'            => '标题',
            'post_excerpt'          => '摘要',
            'post_status'           => '状态',
            'comment_status'        => '评论状态',
            'ping_status'           => 'Ping',
            'post_password'         => '文章密码',
            'post_name'             => 'Post Name',
            'to_ping'               => 'To Ping',
            'pinged'                => 'Pinged',
            'post_modified'         => '最后修改时间',
            'post_modified_gmt'     => '最后修改时间Gmt',
            'post_content_filtered' => 'Post Content Filtered',
            'post_parent'           => 'Post Parent',
            'guid'                  => 'Guid',
            'menu_order'            => 'Menu Order',
            'post_type'             => 'Post Type',
            'comment_count'         => '评论计数',
        ];
    }

    //元数据规则
    //目前只生效  exist(存在)  规则
    public function metaRules()
    {
        return [
            [['article_category'], 'exist'],
        ];
    }

    //元数据键值标签，未定义的键值标签将是键值本身
    public function metaLabels()
    {
        return [
            'article_category' => '文章类别',
        ];
    }

    /**
     * 获取/设置 元数据
     * @param  string/array $options 元数据键值/元数据键值对序列
     *                               options为字符串，不设置$value，则返回值
     *                               options为字符串，设置$value，则设置值
     *                               options键值对序列，按序列则设置值
     * @param  mixed/null $value 值
     * @param  Boolean $encode 是否编码，默认true
     * @return [type]        [description]
     */
    public function meta($options,$value=null,$encode=true)
    {

        //如果键值是字符串
        if(  is_string($options)  )
        {
            //如果不设置值
            if(  is_null($value)  )
            {
                $meta = $this->getMetas($options,$encode);
                if(  is_null($meta)  )return null;
                if ($encode) return $meta->meta_value;
                else return $meta->meta_value;    
            }else
                $this->setMatas($options,$value,$encode);
        }
        //如果键值是数组
        if(  is_array($options)  )
            $this->setMatas($options,null,$encode);
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

    /**
     * 获取元数据标签
     * @param  mixed[string/array/null] $metas 元数据键值或键值序列
     * @return mixed[string/array/null]        对应的元数据标签。元数据为字符串，返回其标签字符串，未定义标签则返回其本身；元数据为数组，则返回以其自身为键值的元数据标签序列；为空返回所有已定义的标签
     */
    public function getMataLabels($meta_keys=null)
    {
        //获取所有的元数据标签
        $metaLabels = $this->metaLabels();

        //如果没有参数，返回全部已定义以的标签
        if(  is_null($meta_keys)  )return $metaLabels;

        //如果参数是字符串
        if(  is_string($meta_keys)  )
            return isset($metaLabels[$meta_keys])?$metaLabels[$meta_keys]:$meta_keys;

        //如果参数是数组
        if(  is_array($meta_keys)  )
        {
            $_arr = null;
            foreach ($meta_keys as $key => $value)
                $_arr[$value] = isset($metaLabels[$value])?$metaLabels[$value]:$value;            
            return $_arr;
        }

        

        return null;
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
     * 获取元数据属性键值对
     * @param  mixed[string/array] $metas 元数据键值/元数据键值序列
     * @return array/null        参数为字符串返回单一元数据/参数为元数据键值序列时返回以元数据键值为键值的元数据序列
    */
    public function getMetaAttributes($meta_keys)
    {
        if(  empty($meta_keys)  ) return null;
        //如果元数据键值是字符串
        if (  is_string($meta_keys)  )
            return $this->getMeta($meta_keys);
        //如果元数据键值是数组序列
        if(  is_array($meta_keys)  )
        {
            $_arr = null;
            foreach ($meta_keys as $km => $meta_key)
            {
                $_mata = $this->getMeta($meta_key);
                if(  !is_null($_mata)  )
                    $_arr[$meta_key] = $this->getMeta($meta_key);
            }
            return $_arr;
        }

        return null;
    }
    
    /**
     * 获取单个元数据属性
     * @param  string $meta 元数据键值
     * @return array/null   元数据属性数组
     */
    public function getMetaAttribute($meta_key)
    {
        $rules = $this->getMetaRules($meta_key);

        if(  is_null($rules)  )return null;

        return 
        [
            'key' => $meta_key,
            'label' => $this->getMataLabels($meta_key),
            'rules' => $rules
        ];
    }


    /**
     * 批量设置元数据
     * @param string/array $options 元数据键值或键值对序列
     * @param mixed $value  元数据值，当参数$options为字符串时生效
     * @param boolean $encode  是否编码，默认true
     */
    public function setMatas($options,$value=null,$encode=true)
    {
        if(  is_string($options) )
            $this->setMeta($options,$value,$encode);

        if(  is_array($options)  )
            foreach ($options as $key => $option)
                $this->setMeta($key,$option,$encode);
    }

    /**
     * 设置元数据
     * @param string $key   元数据键值
     * @param mixed $value 元数据值
     * @param boolean $encode 是否编码，默认true
     * @return  true/false 设置成功或者失败
     */
    public function setMeta($key,$value,$encode=true)
    {
        if(  empty($this->ID)  )return false;

        $meta = $this->getMetas($key);

        if(  is_null($meta)  ){            
            $meta = new Postmeta();
            if(  is_null($this->getMetaRules($key))  ){                
                return false;
            }
            $meta->post_id = $this->ID;
            $meta->meta_key = $key;
        }
  
        $meta->meta_value = ($encode?$this->encodeMetaValue($value):$value);

        if(  !$meta->save()  ){
            //errors：保存到元数据表出错
            throw new ErrorException('保存到元数据表'.$meta->tableName().'出错'); 
            return false;
        }
        return true ;            
    }


    /**
     * 获取指定的元数据
     * @param  mixed[string/array] $metas 元数据键值或者键值序列
     * @param boolean $decode 是否解编码，默认true
     * @return array/null        元数据AR对象或AR对象序列
     */
    public function getMetas($meta_keys,$decode=true){

        if(  $this->getIsNewRecord()  )return null;

        //如果键值为字符串
        if(  is_string($meta_keys)  )return $this->getMeta($meta_keys);

        $metas = null;
        if(  is_array($meta_keys)  )
            $metas = Postmeta::find()->where(['post_id'=>$this->ID,'meta_key'=>$meta_keys])->all();
        if(  is_null($meta_keys)  )
            $metas = Postmeta::find()->where(['post_id'=>$this->ID])->all();
        if(  !empty($metas)  )
            foreach ($metas as $key => $meta)
                if(  $decode  )
                    $metas[$key]['meta_value'] = $this->decodeMetaValue($meta['meta_value']);
        return $metas;
    }

    public function getMeta($meta_key,$decode=true)
    {
        $meta = Postmeta::find()->where(['post_id'=>$this->ID,'meta_key'=>$meta_key])->one();
        if(  $meta && $decode  )$meta->meta_value = $this->decodeMetaValue($meta->meta_value);
        return $meta;
    }
}
