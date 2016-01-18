  <div id="menu">
    <h2 class="first"><?=$nav['title']?></h2>
    <ul>
<?php foreach($nav['menu'] as $k=>$v):?>
<?php if(qd_ctrl_auth($k, $auth)):?>
<?php if($k == $curmenu):?>
	 <li class="current"><a href="<?php echo base_url($k)?>"><?php echo $v;?></a></li>
<?php else:?>
	 <li><a href="<?php echo base_url($k)?>"><?php echo $v;?></a></li>
<?php endif;?>
<?php endif;?>
<?php endforeach;?>
    </ul>
  </div>