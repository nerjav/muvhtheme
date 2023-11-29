  
<?php /* plantilla utilizada para mostrar fecha y categoria de las noticias */ ?>
<style> 
.info1 { 
	
    font-size: 15px;
    /* margin-bottom: 20px; */
    /* margin-top: 57px; */
    float: right;
   
}
</style>
<div class="info1">
<span class="glyphicon glyphicon-time"></span>
<span class="fecha"><?php echo get_the_date('d M Y H:i:s'); ?></span></span>    </div>