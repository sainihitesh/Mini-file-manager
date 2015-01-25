<?php include_once('functions.inc') ?>
<html><title>File Manager by HS</title>
<head>
<link rel="stylesheet" href="js/jquery-ui.css">
<script src='js/jquery.js' type="text/javascript"></script>
<script type="text/javascript" src="js/scripts/shCore.js"></script>
<script src='js/jquery-ui.js' type="text/javascript"></script>
<link rel="stylesheet" href="js/styles/shCoreDefault.css">
<link rel="stylesheet" href="js/vi.css">
<script type="text/javascript">SyntaxHighlighter.all();</script>
<script>
  $(function() {
    $( document ).tooltip({
      track: true
    });
  });
  </script>
<?php


//fucntion for counting no. of folders and files in given directory
function f_D_counter($dir)
         {
            
            if (is_dir($dir)==1) 
            {
            	$folder_count=0;
            	$file_count=0;
                $open=opendir($dir);
                while ( $read= readdir($open)) 
                   {
                	if($read!='.'&&$read!='..')
                      {
                		$n=$dir."/".$read;
                		if (is_dir($n)==1) 
                		{
                		  $folder_count++;
                		  f_D_counter($n);
                		}
                		else
                		{   
                			$file_count++;
                			

                		}
                	   }	
                   }
                   echo"fi".$file_count."fi";
                   echo"fol".$folder_count."fol<br>";	
            }

         }
         if (!empty($_GET['dir'])) {
               f_D_counter($_GET['dir']);
                
                     }
//function for counting folder in fiven directory                      
function count_folder($dir)
    {
preg_match_all('/fol[0-9]fol/',file_get_contents("http://localhost/count_folder.php?dir=$dir"),$file);
$fol=implode("", $file[0]);
preg_match_all('/[0-9]/',$fol,$total);
$x=0;
for($i=0; $i<count($total[0]); $i++)
{
    $x=$x+$total[0][$i];
}
return $x;
    }
//function for counting files in given directory
function count_file($dir)
{
    preg_match_all('/fi[0-9]fi/',file_get_contents("http://localhost/count_folder.php?dir=$dir"),$file);
$fol=implode("", $file[0]);
preg_match_all('/[0-9]/',$fol,$total);
$x=0;
for($i=0; $i<count($total[0]); $i++)
{
    $x=$x+$total[0][$i];
}
return $x;
}
function jsonData($dir)
{
   $data=array();
   if(is_dir($dir)) 
   {
       $open=opendir($dir);
       while ( $read=readdir($open)) 
       {
           if ($read!='.'&&$read!='..') 
           {
              $loc=$dir.'/'.$read;
              array_push($data,$loc);
           }
       }
       $jdata=json_encode($data);
       $fopen=fopen("Data.json","w++");
       $fread=fputs($fopen, $jdata);
       copy("Data.json",$dir.'/Data.json');
   }
}       
function file_type($file)
{
   if (file_exists($file)) 
  {     
  	   $name=basename($file);
  	  
  	   if (preg_match('/./', $name)) 
  	   {
  	      $na=explode('.',$name);
          return  $na[count($na)-1];
  
      }
}
}
function delete_dir($path)
 {
 	if (is_file($path)) {
 		unlink($path);}
 }
function exploreProject($fd)
{
  $filety='';
if(!empty($fd))
{
	if (is_dir($fd)) {
		
	
$read=opendir($fd);
while ($open=readdir($read)) 
{
	if($open!='.'&&$open!='..')
	{
	$rr=count_folder($open);
	$ss=count_file($open);
  if(is_file($open)){$filety='(File)';}else{$filety='(Folder)';}
	$srvr="http://localhost?path=".$fd."/".$open;
	?>
 <div id="hs" title="<?php $detail=detail($open); echo"File Size:{".$detail['size']."bytes} " ;echo 'Last access:{'.$detail['atime']."}      Last modify:{".$detail['mtime']."}";  ?>"> 
<?php 
echo "<a href='$srvr'>$srvr</a><br><k style='color:white; background:black;'>".$open.' '.$filety."</k></div>";
?>
<?php    }
}
 }

elseif (is_file($fd)) {
	
	?>
<script type="text/javascript">
  $.fx.speeds._default = 1000;
  $(function() {
    $( "#aboutfile" ).dialog({
      autoOpen: false,
      show: "blind",
      hide: "explode"
    });
    
    $( "#rerun" ).click(function() {
      $( "#aboutfile" ).dialog( "open" );
      return false;
    });
  });
</script><div id='aboutfile' style="color:black" title="<?php echo 'about file'.$fd; ?>"><?php $detail=detail($fd); echo"File Size: ".$detail['size']."bytes<br> " ;echo 'Last access:'.$detail['atime']." <br>     Last modify:".$detail['mtime']."";  ?></div>
<div id='hss' title="">
   
   <div id='embd'>
    <ul class="lin" ><div>
    setting<button id="rerun"style='margin-left:20p;'></button>
    <button id="select"></button>
  </div>
  <ul>
    <li><a href="http://localhost/?rfile=<?php echo $fd; ?>">See source File</a></li>
    <li><a href="http://localhost/<?php echo $fd; ?>">Run File</a></li>
    <li><a href="http://localhost/?rfile=<?php echo $fd.'#tabs-3';?>">Edit File</a></li>
    <li><a href="http://localhost/?dfile=<?php echo $fd; ?>">Delete File</a></li>
  </ul>
    </ul>
   </div>
   <div id='maind'>

    <a href='http://localhost/?path=<?php echo $fd; ?>'><?php echo $fd; ?></a>
   </div>
</div>
<?php
}
else
 {
 	"<h1>Whoops!! Something Went Wrong..</h1>";
 }
} 
}
function see_file($file)
{
  if (file_exists($file)) 
  {     
  	   $name=basename($file);
  	   if (preg_match('/./', $name)) 
  	   {
  	      $na=explode('.',$name);
          switch ($na[count($na)-1]) 
          {
          	case 'css' || 'CSS':
          	{
              echo"<script src='js/scripts/shBrushCss.js'></script>";
          	  echo"<link type='text/css' rel='stylesheet' href='js/scripts/styles/shCoreDefault.css'>"; 	
              echo "<pre style='baackground:white;' class='brush:css;'>";	
            	 
            }
          	break;
          	case 'js' || 'JS':
          	{
          		echo"<script src='js/scripts/shBrushJScript.js'></script>";
          	    echo"<link type='text/css' rel='stylesheet' href='js/scripts/styles/shCoreDefault.css'>"; 	
            	echo "<pre style='baackground:white;' class='brush:js;'>";
            	 
            }
            break;
            case 'php' ||'inc':
          	{
          		echo"<script src='js/scripts/shBrushPhp.js'></script>";
          	    echo"<link type='text/css' rel='stylesheet' href='js/scripts/styles/shCoreDefault.css'>"; 	
            	echo "<pre style='baackground:white;' class='brush: php;'>";
            	 
            }
            break;
            case 'sql':
          	{
          		echo"<script src='js/scripts/shBrushSql.js'></script>";
          	    echo"<link type='text/css' rel='stylesheet' href='js/scripts/styles/shCoreDefault.css'>"; 	
            	echo "<pre style='baackground:white;' class='brush: sql;'>";
            	 
            }
            break;
          	default:
          		
          		break;
          }

  	   }
  	   $fopen=fopen($file,"r");
  	   
       while ($fread=fread($fopen,13421772)) 
       {
       	echo htmlspecialchars($fread);
       }echo'</pre>';
  }
}
function fetch_file($file)
{
  if (file_exists($file)) 
  { 
   $fopen=fopen($file,"r");
  	   
       while ($fread=fread($fopen,13421772)) 
       {
       	echo $fread;
       }
   }
}      

?>

<script type="text/javascript">
	$(function() {
		
	
		$( "#tabs" ).tabs();
		$( "#editTab" ).tabs();
	});
</script>
<script type="text/javascript">
    $(function() {
	var availableTags =<?php if(!empty($_GET['path'])){if(is_dir($_GET['path'])){echo file_get_Contents('http://localhost/'.$_GET['path'].'/Data.json');}}?>;
    $( ".srchi" ).autocomplete({
      source: availableTags
    });});
</script>
<script>
  $(function() {
    $( "#rerun" )
      .button({
        text: false,
          icons: {
            primary: "ui-icon-gear"
          }

      })
      .click(function() {
        
      })
      .next()
        .button({
          text: false,
          icons: {
            primary: "ui-icon-triangle-1-s"
          }
        })
        .click(function() {
          var menu = $( this ).parent().next().show().position({
            my: "left top",
            at: "left bottom",
            of: this
          });
          $( document ).one( "click", function() {
            menu.hide();
          });
          return false;
        })
        .parent()
          .buttonset()
          .next()
            .hide()
            .menu();
  });
  </script>
</head>
<body>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">File Explorer</a></li>
		<li><a href="#tabs-2">CREATE PROJECTS</a></li>
		<li><a href="#tabs-3">EXPLORER 2</a></li>
    <li><a href="#tabs-4">ABOUT FILE MANAGER</a></li>
	</ul>
	<div id="tabs-1">
	PROJECTS
<ul class="headli">
		<form class='srch'action="<?php $_SERVER["PHP_SELF"];?>" method='GET'>
		PATH=<li class="headlis"><input class='srchi' type="text" name="path"/></li>
		<li class="headlis"><input class='srchs' type="submit" name='submit1' value="SEARCH"/></li>
        </form>		
</ul>
	
    <?php 
    if (!empty($_GET['dfile'])) {
        delete_dir($_GET['dfile']);
    }
	if (!empty($_GET['rfile'])&&empty($_GET['sfile'])&&empty($_GET['path'])) {
    	echo"<a style='color:Cyan;font-size:30px' href='http://localhost?path=".$_GET['rfile']."'>Back</a>({$_GET['rfile']})<br>";
    	see_file($_GET['rfile']);
    }
    else{
	if (empty($_GET['sfile'])) {
		
	
    if (!empty($_GET['path'])&&empty($_GET['cpath'])) {
    	jsonData($_GET['path']);
    	echo"<a style='color:Cyan;font-size:30px' href='http://localhost?path={$_GET['path']}/../'>Back</a>({$_GET['path']})<br>";
    	exploreProject($_GET['path']);
    }
   
    else
    {
    	exploreProject(".");
    }}
    
    elseif(!empty($_GET['sfile'])){
    	echo"<div id='edt'><input type='submit' value='Edit File'/></div>";
    	see_file($_GET['sfile']);
    }}
    
	?>
	
    </div>
	<div id="tabs-2">
		CREATE PROJECTS
		<ul class="headli">CREATE FOLDER
		<form class='srch'action="<?php echo $_SERVER["PHP_SELF"].'#tabs-2';?>" method='GET'>
		<?php if (!empty($_GET['path'])){if(is_dir($_GET['path'])){echo $_GET['path'].'/';} };?><li class="headlis">
        <li class="headlis">
        <input type="hidden" name="path" value="<?php if (!empty($_GET['path'])){if(is_dir($_GET['path'])){echo$_GET['path'];}}?>"/>
		<input class='csrchi' type="text" name="cfile"/></li>
		
		<li class="headlis"><input class='srchs' type="submit" name='submit1' value="CREATE"/></li>
        </form>		
        </ul><ul class="headli">CREATE FILE
    <form class='srch'action="<?php echo $_SERVER["PHP_SELF"].'#tabs-2';?>" method='GET'>
    <?php if (!empty($_GET['path'])){if(is_dir($_GET['path'])){echo $_GET['path'].'/';} };?><li class="headlis">
        <li class="headlis">
        <input type="hidden" name="path" value="<?php if (!empty($_GET['path'])){if(is_dir($_GET['path'])){echo$_GET['path'];}}?>"/>
    <input class='csrchi' type="text" name="cfile"/></li>
    
    <li class="headlis"><input class='srchs' type="submit" name='submit2' value="CREATE"/></li>
        </form>   
        </ul>
        <?php
         if (!empty($_GET['path'])&&is_dir($_GET['path'])&&!empty($_GET['cfile'])) 
{          
  if (!file_exists($_GET['path'].'/'.$_GET['cfile'])) 
  {
       if (!empty($_GET['submit2'])) 
       {
               $pth=$_GET['path'].'/'.$_GET['cfile'];
               $cfile=touch($_GET['path'].'/'.$_GET['cfile']);
               if ($cfile==true) 
               {
                    echo "Project Created.<a href='http://localhost?path={$pth}'>(Open)</a>";
               }
               else
               {
                echo "Problem Occured!!";
               }
       }
       elseif (!empty($_GET['submit1'])) 
       {    
            $pth=$_GET['path'].'/'.$_GET['cfile'];
            $cfile=mkdir($_GET['path'].'/'.$_GET['cfile']);
            if ($cfile==true) 
               {
                    echo "Project Created.<a href='http://localhost?path={$pth}'>(Open)</a>";
               }
               else
               {
                echo "Problem Occured!!";
               }
       }
  }
  else
  {
     echo "File Already Exists <a hrf='http://localhost?path={$_GET['path']}'> {$_GET['path']}</a>";
  }
}          
        ?>
    </div>
	<div id="tabs-3">
		EXPLORER 2<br>
		<p>Say Hello To <a href="http://hiteshs.netai.net">HITESH SAINI</a></p>
    <?php
    if (!empty($_GET['rfile'])&&empty($_GET['sfile'])&&empty($_GET['path'])) 
       {
    	?>
    	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method='POST'>
        <input type="hidden" name='rfile' value='<?php echo $_GET['rfile'];?>'/>
        
        <input type="submit" value="SAVE EDIT" name="EDITFILE"/><br>
        <textarea id='highlightit' style='height:700px;width:700px;' class='<?php echo 'brush:'.file_type($_GET['rfile']);?>' name="textforEdit">
        	<?php fetch_file($_GET['rfile']); ?>
            
        </textarea><br>
        
        <input type="submit" value="SAVE EDIT" name="EDITFILE"/>
    	</form>
    <?php	
    	
    }
	?>
	<?php 
            if (!empty($_POST['EDITFILE'])&&!empty($_POST['textforEdit'])&&!empty($_POST['rfile'])) 
            {
            	$fope=fopen($_POST['rfile'],"w++");
                $fre=fputs($fope, $_POST['textforEdit']);
                fclose($fope);
                $location='http://localhost?path='.$_POST['rfile'];
                echo"<a href='$location'>See Edited File</a>";
            }
             ?></div><div id="tabs-4">
        This software is built in PHP, jquery ,jquery ui, css, and html and used for file management on 
        server. And further it can be used by users for running php scripts directly without setting up any 
        configuration and installing any other software in working machine.<br><br> 
       Why to use this software?
       <br>-this software can be used to run PHP codes through it without setting up any configuration
       and integration.<br><br>
      <p style='text-decoration:underline'> HOW TO </p>
       <p style='text-decoration:underline'>To see a project and files</p>
       -To see a project and files click on the directory which are rendered on screen.
       then it will redirect you to the project's page.
       <br>
       <p style='text-decoration:underline'>To create a new folder and file</p>
       To create a file and folder, first go to that directory as described earlier
       in which a folder or file  are to be created. then Go to the second main tab 
       having title 'Create projects' and give name to folder or to file by filling the first ad 
       second input. and then click on the create button. thus new file or folder wil be create.<br><br>
       <p style='text-decoration:underline'>To edit a Existing file or project</p>
       To Edit a existing file or project  go to the targret file and click on the drop down icon and click on the edit link
       then page will redirect you to the edit page of that file or project. after editing the file click on save button. 
       editing will be saved to actual file. then you can run the edited file or project.
       <p style='text-decoration:underline'>For more help</p> you can contact me on my site <a href="http://hiteshs.netai.net">here</a>
       and my fb profile <a href="https://facebook.com/HiteshSaini99">here</a>
       
        </div>


             </div></div>
<div id='ps'></div>
</body>
</html>

<?php
if(!empty($_GET["fileo"]))
  {
  	    $dir=explode("/",$_GET["fileo"]);

  		delete_dir($dir[count($dir)-2]);
  	
  }
?>
