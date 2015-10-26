<?php

namespace sv\admin\models;

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
    public $_metas = null;
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

        if(  is_string($options)  )
        {
            if(  is_null($value)  )
            {
                $meta = $this->getMetas($options,$encode);
                if(  is_null($meta)  )return null;
                if ($encode) return $meta->meta_value;
                else return $meta->meta_value;    
            }else
                $this->setMatas($options,$value,$encode);
            
        }

        if(  is_array($options)  )
            $this->setMatas($options,null,$encode);
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
            if(  is_null($meta->getMeta($key,$encode))  ){                
                return false;
            }
            $meta->post_id = $this->ID;
            $meta->meta_key = $key;
        }
  
        $meta->meta_value = ($encode?$meta->encodeMetaValue($value):$value);

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
    public function getMetas($metas,$decode=true){

        if(  $this->getIsNewRecord()  )return null;

        if(  is_null($this->_metas)  )
             $this->_metas = Postmeta::find()->where(['post_id'=>$this->ID])->all();

        if(  empty($this->_metas)  )return null;

        if(  is_string($metas)  ){
            foreach ($this->_metas as $key => $meta)
                if(  $meta->meta_key ==  $metas )
                {
                    $meta->meta_value = ($decode?$meta->decodeMetaValue($meta->meta_value):$meta->meta_value);
                    return $meta;
                }
            return null;
        }            

        if(  is_array($metas)  ){
            $_arr = null;
            foreach ($metas as $key => $meta)
                foreach ($this->_metas as $key => $_meta) 
                    if(  $meta == $_meta  )
                    {
                        $_meta->meta_value = ($decode?$meta->decodeMetaValue($_meta->meta_value):$_meta->meta_value);
                        $_arr[] = $_meta;
                    }
                        
            return $_arr;
        }        
        return null;
    }
}
