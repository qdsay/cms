<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  * 静态文件目录
  */
if ( ! function_exists('qd_static_url'))
{
    function qd_static_url($url) {
        $CI =& get_instance();
        return $CI->config->item('static_url') . $url;
    }
}

/**
  * 图片地址
  */
if ( ! function_exists('qd_upload_url'))
{
    function qd_upload_url($url, $p = '') {
        if (! empty($url)) {
            $CI =& get_instance();
            $url = empty($p) ? $url : str_replace(".", "_{$p}.", $url);
            $url = $CI->config->item('static_url') . $url;
        }
        return $url;
    }
}

/**
  * 生成查询字符串
  */
if ( ! function_exists('qd_query_url'))
{
    function qd_query_url($where, $order = '') {
        $query = '';
        if (!empty($where)) {
            foreach ($where as $k=>$v) {
                $query .= empty($query) ? $k .'='. $v : '&'. $k .'='. $v;
            }
        }

        if (!empty($order)) 
            $query .= empty($query) ? 'sort='. $order : '&sort='. $order;

        if (!empty($query)) 
            $query = '?'.$query;

        return $query;
    }
}

/**
  * 返回格式化分类数组
  */
if ( ! function_exists('qd_catalog'))
{
    function qd_catalog($catalog) {
        $result = array();
        foreach ($catalog as $a) { //第一级
            if ($a['grade'] == 0) {
                $result[$a['id']]['name'] = $a['name'];
                foreach ($catalog as $b) { //第二级
                    if ($b['father_id'] == $a['id'] && $b['grade'] == 1) {
                        $result[$a['id']]['child'][$b['id']]['name'] = $b['name'];
                        foreach ($catalog as $c) { //第三级
                            if ($c['father_id'] == $b['id'] && $c['grade'] == 2) {
                                $result[$a['id']]['child'][$b['id']]['child'][$c['id']]['name'] = $c['name'];
                            }
                        }
                    }
                }
            }
        }
        return $result;
    }
}

/**
  * 返回子分类
  */
if ( ! function_exists('qd_catalog_ids'))
{
    function qd_catalog_ids($catalog, $id) {
        $ids = array();
        if (array_key_exists($id, $catalog)) {
            array_push($ids, $id);
            if ($catalog[$id]['grade'] < 2) {
                foreach ($catalog as $a) {
                    if ($a['father_id'] == $id) {
                        array_push($ids, $a['id']);
                        if ($a['grade'] < 2) {
                            foreach ($catalog as $b) {
                                if ($b['father_id'] == $a['id']) {
                                    array_push($ids, $b['id']);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $ids;
    }
}

/**
  * 分类面包屑
  */
if ( ! function_exists('qd_catalog_location'))
{
    function qd_catalog_location($catalog, $catalog_id, $view = false) {
        $location = '';
        if ($catalog_id > 0) {
            $location = $catalog[$catalog_id]['name'];
            if ($view) {
                $location = '<a href="'.base_url('product/'.$catalog[$catalog_id]['id']).'">'.$location.'</a>';
            }
            if ($catalog[$catalog_id]['father_id'] > 0) {
                $father = $catalog[$catalog[$catalog_id]['father_id']];
                $location = '<a href="'.base_url('product/'.$father['id']).'">'.$father['name'].'</a> » ' . $location;
                if ($father['father_id'] > 0) {
                    $father = $catalog[$father['father_id']];
                    $location = '<a href="'.base_url('product/'.$father['id']).'">'.$father['name'].'</a> » ' . $location;
                }
            }
        }
        return $location;
    }
}