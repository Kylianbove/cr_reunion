<?php
 $query_rs_info = $connexion->prepare("SELECT * FROM infosutiles ");
 $query_rs_info->execute();
 $info = $query_rs_info->fetch(); ?>

  

<div class="droiteContent">
<h3><?php echo $info['nom']; ?></h3>
<div class="accroche">

Adresse : <?php echo $info['adresse']; ?></br>

<?php echo $info['cp']; ?>
<?php echo " ".$info['ville']; ?></br>

Téléphone : <a href="tel:<?php echo $info['tel']; ?>"><?php echo $info['tel']; ?></a></br>

Adresse mail : <a href="mailto:<?php echo $info['email']; ?>"><?php echo $info['email']; ?></a></br>


<?php if($info['facebook'] != null){ ?>
	Facebook : <a href="<?php echo $info['facebook']; ?>"><?php echo $info['facebook']; ?></a></br>
<?php } ?>

<?php if($info['twitter'] != null){ ?>
	Twitter : <a href="<?php echo $info['twitter']; ?>"><?php echo $info['twitter']; ?></a></br>
<?php } ?>

<?php if($info['youtube'] != null){ ?>
	Youtube : <a href="<?php echo $info['youtube']; ?>"><?php echo $info['youtube']; ?></a></br>
<?php } ?>

<?php if($info['pinterest'] != null){ ?>
	Pinterest : <a href="<?php echo $info['pinterest']; ?>"><?php echo $info['pinterest']; ?></a></br>
<?php } ?>

<?php if($info['instagram'] != null){ ?>
	Instagram : <a href="<?php echo $info['instagram']; ?>"><?php echo $info['instagram']; ?></a></br>
<?php } ?>

</div>

</div>

<a class="linkBar" style="height: 25px;"></a>