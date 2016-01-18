<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['navigation'] = array(
    'index'=>array(
        'title'=>'首页',
        'menu'=>array(
            'index'=>'用户中心',
            'catalog'=>'分类管理',
            'assist'=>'页面设置',
            'setup'=>'系统设置',
        )
    ),
    'article'=>array(
        'title'=>'文章管理',
        'menu'=>array(
            'article'=>'文章管理',
        )
    ),
    'admin'=>array(
        'title'=>'权限管理',
        'menu'=>array(
            'admin'=>'用户管理',
            'groups'=>'用户组管理'
        )
    )
);