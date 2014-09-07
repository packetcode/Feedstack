
<script src="<?php echo ROOT; ?>lib/jcrop/js/jquery.Jcrop.min.js"></script>

<script type="text/javascript">
$(function(){
  $('.drop').Jcrop({
    onChange: showCoords,
    onSelect: showCoords,
    aspectRatio: 1,
    setSelect:   [20, 20, 220, 220]
  });

  function showCoords(c)
  {
  $('#x').val(c.x);
  $('#y').val(c.y);
  $('#w').val(c.w);
  $('#h').val(c.h);
  };

});

</script>
<style>
.crop-container{
  background:white;
  padding:30px;
}
.drop{
  max-width:600px;
}
.image{
  padding:10px;
}
.inner-container{
  padding:0px;
  background: #f8f8f8;
  max-width:800px;
  margin:0px auto;
}
.crop-head{
  background: #ecf0f1;
  padding:10px;
  font-size: 20px;
}
.heading-name{
  padding-top:10px;
  padding-left: 5px;
}
.cancel{
  background: #e74c3c;
}
.save{
  background: #27ae60;
}
</style>
<?php
  $username = pathang::getInstance('session')->get('liveuser')->username;
    $image = ROOT.'img/users/'.$username.'_original.jpg?'.time();
?>
<link rel="stylesheet" href="<?php echo ROOT; ?>lib/jcrop/css/jquery.Jcrop.min.css" type="text/css" />
<div class="root" root="<?php echo ROOT; ?>" access-token='<?php echo pathang::GetInstance('session')->get('token'); ?>'></div>
<div class="crop-container">
  <div class="inner-container">
  <div class="crop-head">
    <div class="bcol-50">
      <div class="heading-name">
    CROP IMAGE
    </div>
    </div>
    <div class="bcol-50">
      <div class="pull-right">
        <form action="<?php echo ROOT.$username; ?>/cropimage" method="post">
          <input type="hidden" id="x" name="x" />
          <input type="hidden" id="y" name="y" />
          <input type="hidden" id="w" name="w" />
          <input type="hidden" id="h" name="h" />
          <input type="hidden" name="username" value="<?php echo $username; ?>" />
        <button class="btn save" type="submit">save</button> 
        <a href="<?php echo ROOT.$username; ?>"><button class="btn cancel" type="button">cancel</button></a>
      </form>
      </div>
    </div>
  <div class="clear"></div>
</div>
  <div class="image">
    <img src="<?php echo $image;?>" class="drop"/>
  </div>
</div>
</div>