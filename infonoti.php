  
<?php /* plantilla utilizada para mostrar fecha y categoria de las noticias */ ?>
<style> 
.info1 { 
	
    font-size: 15px;
    /* margin-bottom: 20px; */
    /* margin-top: 57px; */
    float: right;
    margin-botom:3px;
   
}
</style>
<div class="info">
<span class="glyphicon glyphicon-time"></span>
<span class="fecha"><?php echo get_the_date('d M Y H:i:s', false); ?></span></span>
    </div>