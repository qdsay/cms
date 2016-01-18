<?php

class template
{
    var $template_dir   = '';
    var $cache_dir      = '';
    var $compile_dir    = '';
    var $cache_lifetime = 3600; // 缓存更新时间, 默认 3600 秒
    var $direct_output  = FALSE;
    var $caching        = FALSE;
    var $template       = array();
    var $force_compile  = FALSE;

    var $_var           = array();
    var $_echash        = '554fcae493e564ee0dc75bdf2ebf94ca';
    var $_foreach       = array();
    var $_current_file  = '';
    var $_expires       = 0;
    var $_errorlevel    = 0;
    var $_nowtime       = NULL;
    var $_checkfile     = true;
    var $_foreachmark   = '';
    var $_seterror      = 0;

    var $_temp_key      = array();  // 临时存放 foreach 里 key 的数组
    var $_temp_val      = array();  // 临时存放 foreach 里 item 的数组

    function __construct()
    {
        $this->template();
    }

    function template()
    {
        $this->_errorlevel = error_reporting();
        $this->_nowtime    = time();
        header('Content-type: text/html; charset=utf-8');
    }

    /**
     * 注册变量
     *
     * @access  public
     * @param   mix      $tpl_var
     * @param   mix      $value
     *
     * @return  void
     */
    function assign($tpl_var, $value = '')
    {
        if (is_array($tpl_var))
        {
            foreach ($tpl_var AS $key => $val)
            {
                if ($key != '')
                {
                    $this->_var[$key] = $val;
                }
            }
        }
        else
        {
            if ($tpl_var != '')
            {
                $this->_var[$tpl_var] = $value;
            }
        }
    }

    /**
     * 显示页面函数
     *
     * @access  public
     * @param   string      $filename
     * @param   sting      $cache_id
     *
     * @return  void
     */
    function display($filename, $cache_id = '')
    {
        $this->_seterror++;
        error_reporting(E_ALL ^ E_NOTICE);

        $this->_checkfile = FALSE;
        $out = $this->fetch($filename, $cache_id);

        if (strpos($out, $this->_echash) !== FALSE)
        {
            $k = explode($this->_echash, $out);
            foreach ($k AS $key => $val)
            {
                if (($key % 2) == 1)
                {
                    $k[$key] = $this->insert_mod($val);
                }
            }
            $out = implode('', $k);
        }
        error_reporting($this->_errorlevel);
        $this->_seterror--;

        echo $out;
    }

    /**
     * 处理模板文件
     *
     * @access  public
     * @param   string      $filename
     * @param   sting      $cache_id
     *
     * @return  sring
     */
    function fetch($filename, $cache_id = '')
    {
        if (!$this->_seterror)
        {
            error_reporting(E_ALL ^ E_NOTICE);
        }
        $this->_seterror++;

        if (strncmp($filename,'str:', 4) == 0)
        {
            $out = $this->_eval($this->fetch_str(substr($filename, 4)));
        }
        else
        {
            if ($this->_checkfile)
            {
                if (!file_exists($filename))
                {
                    $filename = $this->template_dir . '/' . $filename;
                }
            }
            else
            {
                $filename = $this->template_dir . '/' . $filename;
            }

            if ($this->direct_output)
            {
                $this->_current_file = $filename;

                $out = $this->_eval($this->fetch_str(file_get_contents($filename)));
            }
            else
            {
                if ($cache_id && $this->caching)
                {
                    $out = $this->template_out;
                }
                else
                {
                    if (!in_array($filename, $this->template))
                    {
                        $this->template[] = $filename;
                    }

                    $out = $this->make_compiled($filename);

                    if ($cache_id)
                    {
                        $cachename = basename($filename, strrchr($filename, '.')) . '_' . $cache_id;
                        $data = serialize(array('template' => $this->template, 'expires' => $this->_nowtime + $this->cache_lifetime, 'maketime' => $this->_nowtime));
                        $out = str_replace("\r", '', $out);

                        while (strpos($out, "\n\n") !== FALSE)
                        {
                            $out = str_replace("\n\n", "\n", $out);
                        }

                        $hash_dir = $this->cache_dir . '/' . substr(md5($cachename), 0, 1);
                        if (!is_dir($hash_dir))
                        {
                            mkdir($hash_dir);
                        }
                        if (file_put_contents($hash_dir . '/' . $cachename . '.php', '<?php exit;?>' . $data . $out, LOCK_EX) === FALSE)
                        {
                            trigger_error('can\'t write:' . $hash_dir . '/' . $cachename . '.php');
                        }
                        $this->template = array();
                    }
                }
            }
        }

        $this->_seterror--;
        if (!$this->_seterror)
        {
            error_reporting($this->_errorlevel);
        }

        return $out; // 返回html数据
    }

    /**
     * 编译模板函数
     *
     * @access  public
     * @param   string      $filename
     *
     * @return  sring        编译后文件地址
     */
    function make_compiled($filename)
    {
        $name = $this->compile_dir . '/' . basename($filename) . '.php';
        if ($this->_expires)
        {
            $expires = $this->_expires - $this->cache_lifetime;
        }
        else
        {
            $filestat = @stat($name);
            $expires  = $filestat['mtime'];
        }

        $filestat = @stat($filename);

        if ($filestat['mtime'] <= $expires && !$this->force_compile)
        {
            if (file_exists($name))
            {
                $source = $this->_require($name);
                if ($source == '')
                {
                    $expires = 0;
                }
            }
            else
            {
                $source = '';
                $expires = 0;
            }
        }

        if ($this->force_compile || $filestat['mtime'] > $expires)
        {
            $this->_current_file = $filename;
            $source = $this->fetch_str(file_get_contents($filename));

            if (file_put_contents($name, $source, LOCK_EX) === FALSE)
            {
                trigger_error('can\'t write:' . $name);
            }

            $source = $this->_eval($source);
        }

        return $source;
    }

    /**
     * 处理字符串函数
     *
     * @access  public
     * @param   string     $source
     *
     * @return  sring
     */
    function fetch_str($source)
    {
        if(preg_match_all('~(<\?(?:\w+|=)?|\?>|language\s*=\s*[\"\']?php[\"\']?)~is', $source, $sp_match))
        {
            $sp_match[1] = array_unique($sp_match[1]);
            for ($curr_sp = 0, $for_max2 = count($sp_match[1]); $curr_sp < $for_max2; $curr_sp++)
            {
                $source = str_replace($sp_match[1][$curr_sp],'%%%SMARTYSP'.$curr_sp.'%%%',$source);
            }
             for ($curr_sp = 0, $for_max2 = count($sp_match[1]); $curr_sp < $for_max2; $curr_sp++)
            {
                 $source= str_replace('%%%SMARTYSP'.$curr_sp.'%%%', '<?php echo \''.str_replace("'", "\'", $sp_match[1][$curr_sp]).'\'; ?>'."\n", $source);
            }
        }
        // return preg_replace("/{([^\}\{\n]*)}/e", "\$this->select('\\1');", $source);
        return preg_replace_callback("/{([^\}\{\n]*)}/", function($r) { return $this->select($r[1]); }, $source);
    }

    /**
     * 判断是否缓存
     *
     * @access  public
     * @param   string     $filename
     * @param   sting      $cache_id
     *
     * @return  bool
     */
    function is_cached($filename, $cache_id = '')
    {
        $cachename = basename($filename, strrchr($filename, '.')) . '_' . $cache_id;
        if ($this->caching == true && $this->direct_output == FALSE)
        {
            $hash_dir = $this->cache_dir . '/' . substr(md5($cachename), 0, 1);
            if ($data = @file_get_contents($hash_dir . '/' . $cachename . '.php'))
            {
                $data = substr($data, 13);
                $pos  = strpos($data, '<');
                $paradata = substr($data, 0, $pos);
                $para     = @unserialize($paradata);
                if ($para === FALSE || $this->_nowtime > $para['expires'])
                {
                    $this->caching = FALSE;

                    return FALSE;
                }
                $this->_expires = $para['expires'];

                $this->template_out = substr($data, $pos);

                foreach ($para['template'] AS $val)
                {
                    $stat = @stat($val);
                    if ($para['maketime'] < $stat['mtime'])
                    {
                        $this->caching = FALSE;

                        return FALSE;
                    }
                }
            }
            else
            {
                $this->caching = FALSE;

                return FALSE;
            }

            return true;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * 处理{}标签
     *
     * @access  public
     * @param   string      $tag
     *
     * @return  sring
     */
    function select($tag)
    {
        $tag = stripslashes(trim($tag));

        if (empty($tag))
        {
            return '{}';
        }
        elseif ($tag{0} == '*' && substr($tag, -1) == '*') // 注释部分
        {
            return '';
        }
        elseif ($tag{0} == '$') // 变量
        {
            return '<?php echo ' . $this->get_val(substr($tag, 1)) . '; ?>';
        }
        elseif ($tag{0} == '/') // 结束 tag
        {
            switch (substr($tag, 1))
            {
                case 'if':
                    return '<?php endif; ?>';
                    break;

                case 'foreach':
                    if ($this->_foreachmark == 'foreachelse')
                    {
                        $output = '<?php endif; unset($_from); ?>';
                    }
                    else
                    {
                        array_pop($this->_patchstack);
                        $output = '<?php endforeach; endif; unset($_from); ?>';
                    }
                    $output .= "<?php \$this->pop_vars();; ?>";

                    return $output;
                    break;

                case 'literal':
                    return '';
                    break;

                default:
                    return '{'. $tag .'}';
                    break;
            }
        }
        else
        {
            $tag_sel = explode(' ', $tag);
            $tag_sel = array_shift($tag_sel);
            switch ($tag_sel)
            {
                case 'if':

                    return $this->_compile_if_tag(substr($tag, 3));
                    break;

                case 'else':

                    return '<?php else: ?>';
                    break;

                case 'elseif':

                    return $this->_compile_if_tag(substr($tag, 7), true);
                    break;

                case 'foreachelse':
                    $this->_foreachmark = 'foreachelse';

                    return '<?php endforeach; else: ?>';
                    break;

                case 'foreach':
                    $this->_foreachmark = 'foreach';
                    if(!isset($this->_patchstack))
                    {
                        $this->_patchstack = array();
                    }
                    return $this->_compile_foreach_start(substr($tag, 8));
                    break;

                case 'break':
                    return '<?php break; ?>';
                    break;

                case 'assign':
                    $t = $this->get_para(substr($tag, 7),0);

                    if ($t['value']{0} == '$')
                    {
                        /* 如果传进来的值是变量，就不用用引号 */
                        $tmp = '$this->assign(\'' . $t['var'] . '\',' . $t['value'] . ');';
                    }
                    else
                    {
                        $tmp = '$this->assign(\'' . $t['var'] . '\',\'' . addcslashes($t['value'], "'") . '\');';
                    }
                    // $tmp = $this->assign($t['var'], $t['value']);

                    return '<?php ' . $tmp . ' ?>';
                    break;

                case 'include':
                    $t = $this->get_para(substr($tag, 8), 0);

                    return '<?php echo $this->fetch(' . "'$t[file]'" . '); ?>';
                    break;

                case 'insert_scripts':
                    $t = $this->get_para(substr($tag, 15), 0);

                    return '<?php echo $this->smarty_insert_scripts(' . $this->make_array($t) . '); ?>';
                    break;

                case 'insert' :
                    $t = $this->get_para(substr($tag, 7), FALSE);

                    //$out = "<?php \n" . '$k = ' . preg_replace("/(\'\\$[^,]+)/e" , "stripslashes(trim('\\1','\''));", var_export($t, true)) . ";\n";
                    $out = "<?php \n" . '$k = ' . preg_replace_callback("/(\'\\$[^,]+)/" , function($r) { return stripslashes(trim($r[1],'\'')); }, var_export($t, true)) . ";\n";
                    $out .= 'echo $this->_echash . $k[\'name\'] . \'|\' . serialize($k) . $this->_echash;' . "\n?>";

                    return $out;
                    break;

                case 'literal':
                    return '';
                    break;

                default:
                    return '{' . $tag . '}';
                    break;
            }
        }
    }

    /**
     * 处理smarty标签中的变量标签
     *
     * @access  public
     * @param   string     $val
     *
     * @return  bool
     */
    function get_val($val)
    {
        if (strrpos($val, '[') !== FALSE)
        {
            // $val = preg_replace("/\[([^\[\]]*)\]/eis", "'.'.str_replace('$','\$','\\1')", $val);
            $val = preg_replace_callback("/\[([^\[\]]*)\]/is", function($r) {return '.'.$r[1]; }, $val);
        }

        if (strrpos($val, '|') !== FALSE)
        {
            $moddb = explode('|', $val);
            $val = array_shift($moddb);
        }

        if (empty($val))
        {
            return '';
        }

        if (strpos($val, '.$') !== FALSE)
        {
            $all = explode('.$', $val);

            foreach ($all AS $key => $val)
            {
                $all[$key] = $key == 0 ? $this->make_var($val) : '['. $this->make_var($val) . ']';
            }
            $p = implode('', $all);
        }
        else
        {
            $p = $this->make_var($val);
        }

        if (!empty($moddb))
        {
            foreach ($moddb AS $key => $mod)
            {
                $s = explode(':', $mod);
                switch ($s[0])
                {
                    case 'escape':
                        $s[1] = trim($s[1], '"');
                        if ($s[1] == 'html')
                        {
                            $p = 'htmlspecialchars(' . $p . ')';
                        }
                        elseif ($s[1] == 'url')
                        {
                            $p = 'urlencode(' . $p . ')';
                        }
                        elseif ($s[1] == 'decode_url')
                        {
                            $p = 'urldecode(' . $p . ')';
                        }
                        elseif ($s[1] == 'quotes')
                        {
                            $p = 'addslashes(' . $p . ')';
                        }
                        elseif ($s[1] == 'u8_url')
                        {
                            if (QD_CHARSET != 'utf-8')
                            {
                                $p = 'urlencode(iconv("' . QD_CHARSET . '", "utf-8",' . $p . '))';
                            }
                            else
                            {
                                $p = 'urlencode(' . $p . ')';
                            }
                        }
                        else
                        {
                            $p = 'htmlspecialchars(' . $p . ')';
                        }
                        break;

                    case 'nl2br':
                        $p = 'nl2br(' . $p . ')';
                        break;

                    case 'default':
                        $s[1] = $s[1]{0} == '$' ?  $this->get_val(substr($s[1], 1)) : "'$s[1]'";
                        $p = 'empty(' . $p . ') ? ' . $s[1] . ' : ' . $p;
                        break;

                    case 'truncate':
                        $p = 'substr(' . $p . ",$s[1])";
                        break;

                    case 'strip_tags':
                        $p = 'strip_tags(' . $p . ')';
                        break;

                    case 'ucfirst':
                        $p = 'ucfirst(' . $p . ')';
                        break;

                    case 'idrpos':
                        $p = 'strrpos(' . $p . ", '_id')";
                        break;

                    case 'strip_id':
                        $p = 'substr(' . $p . ', 0, strrpos(' . $p . ', "_id"))';
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }

        return $p;
    }

    /**
     * 处理去掉$的字符串
     *
     * @access  public
     * @param   string     $val
     *
     * @return  bool
     */
    function make_var($val)
    {
        if (strrpos($val, '.') === FALSE)
        {
            if (isset($this->_var[$val]) && isset($this->_patchstack[$val]))
            {
                $val = $this->_patchstack[$val];
            }
            $p = '$this->_var[\'' . $val . '\']';
        }
        else
        {
            $t = explode('.', $val);
            $_var_name = array_shift($t);
            if (isset($this->_var[$_var_name]) && isset($this->_patchstack[$_var_name]))
            {
                $_var_name = $this->_patchstack[$_var_name];
            }
            if ($_var_name == 'smarty')
            {
                 $p = $this->_compile_smarty_ref($t);
            }
            else
            {
                $p = '$this->_var[\'' . $_var_name . '\']';
            }
            foreach ($t AS $val)
            {
                $p.= '[\'' . $val . '\']';
            }
        }

        return $p;
    }

    /**
     * 处理insert外部函数/需要include运行的函数的调用数据
     *
     * @access  public
     * @param   string     $val
     * @param   int         $type
     *
     * @return  array
     */
    function get_para($val, $type = 1) // 处理insert外部函数/需要include运行的函数的调用数据
    {
        $pa = $this->str_trim($val);
        foreach ($pa AS $value)
        {
            if (strrpos($value, '='))
            {
                list($a, $b) = explode('=', str_replace(array(' ', '"', "'", '&quot;'), '', $value));
                if ($b{0} == '$')
                {
                    if ($type)
                    {
                        eval('$para[\'' . $a . '\']=' . $this->get_val(substr($b, 1)) . ';');
                    }
                    else
                    {
                        $para[$a] = $this->get_val(substr($b, 1));
                    }
                }
                else
                {
                    $para[$a] = $b;
                }
            }
        }

        return $para;
    }

    /**
     * 判断变量是否被注册并返回值
     *
     * @access  public
     * @param   string     $name
     *
     * @return  mix
     */
    function &get_template_vars($name = NULL)
    {
        if (empty($name))
        {
            return $this->_var;
        }
        elseif (!empty($this->_var[$name]))
        {
            return $this->_var[$name];
        }
        else
        {
            $_tmp = NULL;

            return $_tmp;
        }
    }

    /**
     * 处理if标签
     *
     * @access  public
     * @param   string     $tag_args
     * @param   bool       $elseif
     *
     * @return  string
     */
    function _compile_if_tag($tag_args, $elseif = FALSE)
    {
        preg_match_all('/\-?\d+[\.\d]+|\'[^\'|\s]*\'|"[^"|\s]*"|[\$\w\.]+|!==|===|==|!=|<>|<<|>>|<=|>=|&&|\|\||\(|\)|,|\!|\^|=|&|<|>|~|\||\%|\+|\-|\/|\*|\@|\S/', $tag_args, $match);

        $tokens = $match[0];
        // make sure we have balanced parenthesis
        $token_count = array_count_values($tokens);
        if (!empty($token_count['(']) && $token_count['('] != $token_count[')'])
        {
            // $this->_syntax_error('unbalanced parenthesis in if statement', E_USER_ERROR, __FILE__, __LINE__);
        }

        for ($i = 0, $count = count($tokens); $i < $count; $i++)
        {
            $token = &$tokens[$i];
            switch (strtolower($token))
            {
                case 'eq':
                    $token = '==';
                    break;

                case 'ne':
                case 'neq':
                    $token = '!=';
                    break;

                case 'lt':
                    $token = '<';
                    break;

                case 'le':
                case 'lte':
                    $token = '<=';
                    break;

                case 'gt':
                    $token = '>';
                    break;

                case 'ge':
                case 'gte':
                    $token = '>=';
                    break;

                case 'and':
                    $token = '&&';
                    break;

                case 'or':
                    $token = '||';
                    break;

                case 'not':
                    $token = '!';
                    break;

                case 'mod':
                    $token = '%';
                    break;

                default:
                    if ($token[0] == '$')
                    {
                        $token = $this->get_val(substr($token, 1));
                    }
                    break;
            }
        }

        if ($elseif)
        {
            return '<?php elseif (' . implode(' ', $tokens) . '): ?>';
        }
        else
        {
            return '<?php if (' . implode(' ', $tokens) . '): ?>';
        }
    }

    /**
     * 处理foreach标签
     *
     * @access  public
     * @param   string     $tag_args
     *
     * @return  string
     */
    function _compile_foreach_start($tag_args)
    {
        $attrs = $this->get_para($tag_args, 0);
        $arg_list = array();
        $from = $attrs['from'];
        if(isset($this->_var[$attrs['item']]) && !isset($this->_patchstack[$attrs['item']]))
        {
            $this->_patchstack[$attrs['item']] = $attrs['item'] . '_' . str_replace(array(' ', '.'), '_', microtime());
            $attrs['item'] = $this->_patchstack[$attrs['item']];
        }
        else
        {
            $this->_patchstack[$attrs['item']] = $attrs['item'];
        }
        $item = $this->get_val($attrs['item']);

        if (!empty($attrs['key']))
        {
            $key = $attrs['key'];
            $key_part = $this->get_val($key).' => ';
        }
        else
        {
            $key = NULL;
            $key_part = '';
        }

        if (!empty($attrs['name']))
        {
            $name = $attrs['name'];
        }
        else
        {
            $name = NULL;
        }

        $output = '<?php ';
        $output .= "\$_from = $from; if (!is_array(\$_from) && !is_object(\$_from)) { settype(\$_from, 'array'); }; \$this->push_vars('$attrs[key]', '$attrs[item]');";

        if (!empty($name))
        {
            $foreach_props = "\$this->_foreach['$name']";
            $output .= "{$foreach_props} = array('total' => count(\$_from), 'iteration' => 0);\n";
            $output .= "if ({$foreach_props}['total'] > 0):\n";
            $output .= "    foreach (\$_from AS $key_part$item):\n";
            $output .= "        {$foreach_props}['iteration']++;\n";
        }
        else
        {
            $output .= "if (count(\$_from)):\n";
            $output .= "    foreach (\$_from AS $key_part$item):\n";
        }
        return $output . '?>';
    }


    /**
     * 将 foreach 的 key, item 放入临时数组
     *
     * @param  mixed    $key
     * @param  mixed    $val
     *
     * @return  void
     */
    function push_vars($key, $val)
    {
        if (!empty($key))
        {
            array_push($this->_temp_key, "\$this->_vars['$key']='" .$this->_vars[$key] . "';");
        }
        if (!empty($val))
        {
            array_push($this->_temp_val, "\$this->_vars['$val']='" .$this->_vars[$val] ."';");
        }
    }

    /**
     * 弹出临时数组的最后一个
     *
     * @return  void
     */
    function pop_vars()
    {
        $key = array_pop($this->_temp_key);
        $val = array_pop($this->_temp_val);

        if (!empty($key))
        {
            eval($key);
        }
    }

    /**
     * 处理smarty开头的预定义变量
     *
     * @access  public
     * @param   array   $indexes
     *
     * @return  string
     */
    function _compile_smarty_ref(&$indexes)
    {
        /* Extract the reference name. */
        $_ref = $indexes[0];

        switch ($_ref)
        {
            case 'now':
                $compiled_ref = 'time()';
                break;

            case 'foreach':
                array_shift($indexes);
                $_var = $indexes[0];
                $_propname = $indexes[1];
                switch ($_propname)
                {
                    case 'index':
                        array_shift($indexes);
                        $compiled_ref = "(\$this->_foreach['$_var']['iteration'] - 1)";
                        break;

                    case 'first':
                        array_shift($indexes);
                        $compiled_ref = "(\$this->_foreach['$_var']['iteration'] <= 1)";
                        break;

                    case 'last':
                        array_shift($indexes);
                        $compiled_ref = "(\$this->_foreach['$_var']['iteration'] == \$this->_foreach['$_var']['total'])";
                        break;

                    case 'show':
                        array_shift($indexes);
                        $compiled_ref = "(\$this->_foreach['$_var']['total'] > 0)";
                        break;

                    default:
                        $compiled_ref = "\$this->_foreach['$_var']";
                        break;
                }
                break;

            case 'get':
                $compiled_ref = '$_GET';
                break;

            case 'post':
                $compiled_ref = '$_POST';
                break;

            case 'cookies':
                $compiled_ref = '$_COOKIE';
                break;

            case 'env':
                $compiled_ref = '$_ENV';
                break;

            case 'server':
                $compiled_ref = '$_SERVER';
                break;

            case 'request':
                $compiled_ref = '$_REQUEST';
                break;

            case 'session':
                $compiled_ref = '$_SESSION';
                break;

            default:
                break;
        }
        array_shift($indexes);

        return $compiled_ref;
    }

    function insert_mod($name) // 处理动态内容
    {
        list($fun, $para) = explode('|', $name);
        $para = unserialize($para);
        $fun = 'insert_' . $fun;

        return $fun($para);
    }

    function str_trim($str)
    {
        /* 处理'a=b c=d k = f '类字符串，返回数组 */
        while (strpos($str, '= ') != 0)
        {
            $str = str_replace('= ', '=', $str);
        }
        while (strpos($str, ' =') != 0)
        {
            $str = str_replace(' =', '=', $str);
        }

        return explode(' ', trim($str));
    }

    function _eval($content)
    {
        ob_start();
        eval('?' . '>' . trim($content));
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    function _require($filename)
    {
        ob_start();
        include $filename;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

}

?>