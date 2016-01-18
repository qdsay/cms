<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  * 生成存储目录
  */
if ( ! function_exists('qd_url'))
{
    function qd_url($image, $p = '') {
        return empty($p) ? $image : str_replace(".", "_$p.", $image);
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
  * 生成查询字符串
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
  * 生成查询字符串
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

/**
  * 生成查询字符串
  */
if ( ! function_exists('qd_href'))
{
    function qd_href($prefix, $time, $id) {
        return base_url($prefix.'/'.date('Ymd', $time).'/'.$id.'.html');
    }
}

/**
  * 补全
  */
if ( ! function_exists('qd_color'))
{
    function qd_color($color) {
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        list($r, $g, $b) = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);

        if ($r > 180 && $g > 180 && $b > 180) {
            return '#000000';
        } else {
            return '#FFFFFF';
        }
    }
}

/**
  * 生成查询字符串
  */
if ( ! function_exists('qd_china_color'))
{
    function qd_china_color($offset = 0, $length = 0) {
        $color = array('#ffb3a7'=>'粉红','#ed5736'=>'妃红色','#f00056'=>'品红','#f47983'=>'桃红','#db5a6b'=>'海棠红','#f20c00'=>'石榴红','#c93756'=>'樱桃色','#f05654'=>'银红','#ff2121'=>'大红','#8c4356'=>'绛紫','#c83c23'=>'绯红','#9d2933'=>'胭脂','#ff4c00'=>'朱红','#ff4e20'=>'丹','#f35336'=>'彤','#cb3a56'=>'茜色','#ff2d51'=>'火红','#c91f37'=>'赫赤','#ef7a82'=>'嫣红','#ff0097'=>'洋红色橘红','#ff3300'=>'炎','#c3272b'=>'赤','#a98175'=>'绾','#c32136'=>'枣红','#b36d61'=>'檀','#be002f'=>'殷红','#dc3023'=>'酡红','#f9906f'=>'酡颜','#fff143'=>'鹅黄','#faff72'=>'鸭黄','#eaff56'=>'樱草色','#ffa631'=>'杏黄','#ff8c31'=>'杏红','#ff8936'=>'橘黄','#ffa400'=>'橙黄','#ff7500'=>'橘红','#ffc773'=>'姜黄','#f0c239'=>'缃色','#fa8c35'=>'橙色','#b35c44'=>'茶色','#a88462'=>'驼色','#c89b40'=>'昏黄','#60281e'=>'栗色','#b25d25'=>'棕色','#827100'=>'棕绿','#7c4b00'=>'棕黑','#9b4400'=>'棕红','#ae7000'=>'棕黄','#9c5333'=>'赭','#955539'=>'赭色','#ca6924'=>'琥珀','#6e511e'=>'褐色','#d3b17d'=>'枯黄','#e29c45'=>'黄栌','#896c39'=>'秋色','#d9b611'=>'秋香色','#bddd22'=>'嫩绿','#c9dd22'=>'柳黄','#afdd22'=>'柳绿','#789262'=>'竹青','#a3d900'=>'葱黄','#9ed900'=>'葱绿','#0eb83a'=>'葱青','#0eb83a'=>'葱倩','#0aa344'=>'青葱','#00bc12'=>'油绿','#0c8918'=>'绿沈','#1bd1a5'=>'碧色','#2add9c'=>'碧绿','#48c0a3'=>'青碧','#3de1ad'=>'翡翠色','#40de5a'=>'草绿','#00e09e'=>'青色','#00e079'=>'青翠','#c0ebd7'=>'青白','#e0eee8'=>'鸭卵青','#bbcdc5'=>'蟹壳青','#424c50'=>'鸦青','#00e500'=>'绿色','#9ed048'=>'豆绿','#96ce54'=>'豆青','#7bcfa6'=>'石青','#2edfa3'=>'玉色','#7fecad'=>'缥','#a4e2c6'=>'艾绿','#21a675'=>'松柏绿','#057748'=>'松花绿','#bce672'=>'松花色','#44cef6'=>'蓝','#177cb0'=>'靛青','#065279'=>'靛蓝','#3eede7'=>'碧蓝','#70f3ff'=>'蔚蓝','#4b5cc4'=>'宝蓝','#a1afc9'=>'蓝灰色','#2e4e7e'=>'藏青','#3b2e7e'=>'藏蓝','#4a4266'=>'黛','#4a4266'=>'黛螺','#4a4266'=>'黛色','#426666'=>'黛绿','#425066'=>'黛蓝','#574266'=>'黛紫','#8d4bbb'=>'紫色','#815463'=>'紫酱','#815476'=>'酱紫','#4c221b'=>'紫檀','#003371'=>'绀紫 绀青','#56004f'=>'紫棠','#801dae'=>'青莲','#4c8dae'=>'群青','#b0a4e3'=>'雪青','#cca4e3'=>'丁香色','#edd1d8'=>'藕色','#e4c6d0'=>'藕荷色','#75878a'=>'苍色','#a29b7c'=>'苍黄','#7397ab'=>'苍青','#395260'=>'苍黑','#d1d9e0'=>'苍白','#88ada6'=>'水色','#d4f2e7'=>'水绿','#d2f0f4'=>'水蓝','#d3e0f3'=>'淡青','#30dff3'=>'湖蓝','#25f8cb'=>'湖绿','#ffffff'=>'精白','#fffbf0'=>'象牙白','#f0fcff'=>'雪白','#d6ecf0'=>'月白','#f2ecde'=>'缟','#e0f0e9'=>'素','#f3f9f1'=>'荼白','#e9f1f6'=>'霜色','#c2ccd0'=>'花白','#fcefe8'=>'鱼肚白','#e3f9fd'=>'莹白','#808080'=>'灰色','#eedeb0'=>'牙色','#f0f0f4'=>'铅白','#622a1d'=>'玄色','#3d3b4f'=>'玄青','#725e82'=>'乌色','#392f41'=>'乌黑','#161823'=>'漆黑','#50616d'=>'墨色','#758a99'=>'墨灰','#000000'=>'黑色','#493131'=>'缁色','#312520'=>'象牙黑','#5d513c'=>'黧','#75664d'=>'黎','#6b6882'=>'黝','#665757'=>'黝黑','#41555d'=>'黯','#f2be45'=>'赤金','#eacd76'=>'金色','#e9e7ef'=>'银白','#549688'=>'铜绿','#a78e44'=>'乌金','#bacac6'=>'老银','#bf242a'=>'银朱','#9d2933'=>'胭脂','#ff461f'=>'朱砂','#f36838'=>'朱膘','#845a33'=>'赭石','#16a951'=>'石绿','#fff2df'=>'白粉','#003472'=>'花青','#ffb61e'=>'藤黄','#845a33'=>'赭石色','#ffc64b'=>'雌黄','#e9bb1d'=>'雄黄','#e9bb1d'=>'石黄','#ff4777'=>'洋红');
        if ($offset != 0 && $length != 0) {
            return array_slice($color, $offset, $length);
        } else  {
            return $color;
        }
    }
}

/**
  * 生成查询字符串
  */
if ( ! function_exists('qd_metro_color'))
{
    function qd_metro_color($offset = 0, $length = 0) {
        $color = array('#252525', '#006AC1', '#691BB8', '#F4B300', '#001E4E', '#1FAEFF', '#78BA00', '#008287', '#1B58B8', '#2673EC', '#004D60', '#56C5FF', '#AE113D', '#119900', '#569CE3', '#632F00', '#004A00', '#00D8CC', '#2E1700', '#00C13F', '#00AAAA', '#B01E00', '#15992A', '#91D100', '#4E0000', '#FF981D', '#83BA1F', '#4E0038', '#E56C19', '#E1B700', '#C1004F', '#FF2E12', '#D39DD9', '#7200AC', '#B81B1B', '#FF768C', '#2D004E', '#FF1D77', '#E064B7', '#4617B4', '#B81B6C', '#1F0068', '#AA40FF', '#FF7D23', '#696969');
        if ($offset != 0 && $length != 0) {
            return array_slice($color, $offset, $length);
        } else  {
            return $color;
        }
    }
}

/**
  * 补全
  */
if ( ! function_exists('qd_keywords'))
{
    function qd_keywords($keywords) {
        $html = '';
        $keywords = preg_replace('/[,]+/', ',', $keywords);
        $keywords = explode(',', $keywords);
        if (count($keywords) > 1) {
            foreach ($keywords as $v) {
                $html .= '<em>'.$v.'</em>';
            }
        }
        return $html;
    }
}