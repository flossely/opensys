<?php
$dir = '.';
include 'getinit.php';
$coord = file_get_contents('user.coord');
$coordExp = explode(';', $coord);
$coordX = $coordExp[0];
$coordY = $coordExp[1];
$coordZ = $coordExp[2];
$coordForm = $coordX.'-'.$coordY.'-'.$coordZ;
$controls = ($_REQUEST['controls']) ? $_REQUEST['controls'] : 'no';
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<title>OpenSys</title>
<link rel="shortcut icon" href="favicon.png?rev=<?=time();?>" type="image/x-icon">
<?php if (file_exists($coordForm.'.css')) { ?>
<link href="<?=$coordForm.'.css';?>" rel="stylesheet">
<?php } else { ?>
<link href="default.css?rev=<?=time();?>" rel="stylesheet">
<?php } ?>
<script src="jquery.js"></script>
<script src="base.js"></script>
<script>
function move(side) {
    var x = Number(memX.value);
    var y = Number(memY.value);
    var z = Number(memZ.value);
    if (side == 'a') {
        x = x - 1;
    } else if (side == 'd') {
        x = x + 1;
    } else if (side == 'r') {
        y = y + 1;
    } else if (side == "f") {
        y = y - 1;
    } else if (side == 'w') {
        z = z + 1;
    } else if (side == 's') {
        z = z - 1;
    }
    var name = 'user.coord';
    var content = x + ';' + y + ';' + z;
    var dataString = 'name=' + name + '&content=' + content;
    $.ajax({
        type: "POST",
        url: "write.php",
        data: dataString,
        cache: false,
        success: function(html) {
            document.location.reload();
        }
    });
    return false;
}
</script>
</head>
<body>
<input id='memX' type='hidden' value="<?=$coordX;?>">
<input id='memY' type='hidden' value="<?=$coordY;?>">
<input id='memZ' type='hidden' value="<?=$coordZ;?>">
<?php if ($controls == 'yes') { ?>
<div class='top'>
<p align="center">
<label id="dispX" name="<?=$coordX;?>"><?=$coordX;?></label>
<label> : </label>
<label id="dispY" name="<?=$coordY;?>"><?=$coordY;?></label>
<label> : </label>
<label id="dispZ" name="<?=$coordZ;?>"><?=$coordZ;?></label>
<input type="button" class="actionButton" value="W" title="Forward" onclick="move('w');">
<input type="button" class="actionButton" value="S" title="Back" onclick="move('s');">
<input type="button" class="actionButton" value="A"
title="Left" onclick="move('a');">
<input type="button" class="actionButton" value="D" title="Right" onclick="move('d');">
<input type="button" class="actionButton" value="R" title="Up" onclick="move('r');">
<input type="button" class="actionButton" value="F" title="Down" onclick="move('f');">
<input type="button" class="actionButton" value="H" title="Hide Panel" onclick="window.location.href='openspace.php';">
<input type="button" class="actionButton" value="Q" title="Edit Stylesheet" onclick="window.location.href='edit.php?name='+dispX.innerText+'-'+dispY.innerText+'-'+dispZ.innerText+'.css&lock=false';">
<input type="button" class="actionButton" value="E" title="Edit" onclick="window.location.href='edit.php?name='+dispX.innerText+'-'+dispY.innerText+'-'+dispZ.innerText+'.php&lock=false';">
<input type="button" class="actionButton" value="U" title="Update" onclick="get('i', 'from', '<?=$thisSystem;?>', '<?=$srcPubRepo;?>');">
<input type="button" class="actionButton" value="X" title="Exit" onclick="get('r', '<?=$thisSystem;?>' ,'hsis', '<?=$srcPubRepo;?>');">
</p>
</div>
<div class='panel'>
<?php
if (file_exists($coordForm.'.php')) {
    include $coordForm.'.php';
}
?>
<?php
} elseif ($controls == 'no') {
    if (file_exists($coordForm.'.php')) {
        include $coordForm.'.php';
    }
}
?>
</div>
</body>
</html>
