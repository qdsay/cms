<div id="header">
  <div id="qdsay"><img src="<?php echo base_url('images/small.png')?>" /></div>
  <div id="nav">
    <ul>
<?php foreach($navbar as $k=>$row):?>
<?php if(isset($auth[$k]) || $k == "index"):?>
<?php if($k == $curnav):?>
      <li class="current"><a href="<?php echo base_url($k)?>" title="<?php echo $k;?>"><?php echo $row['title'];?></a></li>
<?php else:?>
      <li><a href="<?php echo base_url($k)?>" title="<?php echo $k;?>"><?php echo $row['title'];?></a></li>
<?php endif;?>
<?php endif;?>
<?php endforeach;?>
    </ul>
  </div>
  <div id="act">欢迎回来：<?php echo $user['username'];?> | <a href="<?php echo base_url('login/out')?>">退出</a></div>
</div>