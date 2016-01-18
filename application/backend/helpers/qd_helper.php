<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  * 检查权限
  */
if ( ! function_exists('qd_ctrl_auth'))
{
    function qd_ctrl_auth($code, $auth) {
        if ($code == 'index') {
            return true;
        } elseif (array_key_exists($code, $auth)) {
            return true;
        } elseif (strpos($code, '/')) {
            list($ctrl, $func) = explode('/', $code);
            if (array_key_exists($ctrl, $auth)) {
                foreach ($auth[$ctrl] as $methods) {
                    if (in_array($func, $methods)) {
                        break;
                    }
                }
                return true;
            }
        }
        return false;
    }
}

/**
  * 检查权限
  */
if ( ! function_exists('qd_func_auth'))
{
    function qd_func_auth($func, $auth, $base) {
        if (array_key_exists($base, $auth) && in_array($func, $auth[$base])) {
            return true;
        }
        return false;
    }
}

/**
  * 返回上级分类，以"_"分割
  */
if ( ! function_exists('qd_trace_catalog'))
{
    function qd_trace_catalog($catalog, $element_id) {
        $trace = $element_id;
        if (array_key_exists($element_id, $catalog)) {
            $father_id = $catalog[$element_id]['father_id'];
            if ($father_id != 0) {
                $trace = $father_id . '_' . $trace;
                if (array_key_exists($father_id, $catalog)) {
                    $father_id = $catalog[$father_id]['father_id'];
                    if ($father_id != 0) {
                        $trace = $father_id . '_' . $trace;
                    }
                }
            }
        }
        return $trace;
    }
}

/**
  * 格式化数组
  */
if ( ! function_exists('qd_format_catalog'))
{
    function qd_format_catalog($catalog) {
        $option = array();
        foreach ($catalog as $a) { //第一级
            if ($a['grade'] == 0) {
                $option[$a['id']]['name'] = $a['name'];
                foreach ($catalog as $b) { //第二级
                    if ($b['father_id'] == $a['id'] && $b['grade'] == 1) {
                        $option[$a['id']]['option'][$b['id']]['name'] = $b['name'];
                        foreach ($catalog as $c) { //第三级
                            if ($c['father_id'] == $b['id'] && $c['grade'] == 2) {
                                $option[$a['id']]['option'][$b['id']]['option'][$c['id']]['name'] = $c['name'];
                            }
                        }
                    }
                }
            }
        }
        return json_encode($option);
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
  * 生成查询字符串
  */
if ( ! function_exists('qd_query_url'))
{
    function qd_query_url($where, $order = '') {
        $query = '';
        if (!empty($where)) {
            foreach ($where as $k => $v) {
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
  * 反转排序
  */
if ( ! function_exists('qd_order_by'))
{
    function qd_order_by($base_url, $query_url, $field, $note, $direct = 'desc') {
        if (! empty($query_url)) {
            preg_match_all('/^\?.*order=([a-z]+)-(asc|desc){1}$/', $query_url, $match);
            if (isset($match[1]) && isset($match[1][0]) && $match[1][0] == $field) { //控制翻转
                $order = array('asc'=>'desc', 'desc'=>'asc');
                $query_url = preg_replace('/order='.$match[1][0].'-'.$match[2][0].'$/', 'order='.$match[1][0].'-'.$order[$match[2][0]], $query_url);
                return '<a href="'.base_url($base_url).$query_url.'">'.$note.'<b class="sort '.$match[2][0].'"></b></a>';
            }
        }
        return '<a href="'.base_url($base_url)."?order=".$field.'-'.$direct.'">'.$note.'<b class="sort"></b></a>';

    }
}

/**
  * 格式化Tag标签
  */
if ( ! function_exists('qd_cleanup'))
{
    function qd_cleanup($tags) {
        return str_replace(array('，','、',' ','　'), ',', $tags);
    }
}

/**
  * UTF8双字节截取
  */
if ( ! function_exists('qd_substr'))
{
    function qd_substr($string, $start, $length, $dot = '')
    {
        if (qd_strlen($string) <= $length)
        {
            return $string;
        }

        if (function_exists('mb_substr'))
        {
            return mb_substr($string, $start, $length, 'UTF-8') . $dot;
        }
        else
        {
            return iconv_substr($string, $start, $length, 'UTF-8') . $dot;
        }
    }
}

/**
  * UTF8双字节长度
  */
if ( ! function_exists('qd_strlen'))
{
    function qd_strlen($string)
    {
        if (function_exists('mb_strlen'))
        {
            return mb_strlen($string, 'UTF-8');
        }
        else
        {
            return iconv_strlen($string, 'UTF-8');
        }
    }
}