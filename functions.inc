        	<?php
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
//file type name 
function file_type_name($path)
{
   if (file_exists($file)) 
   {
      $rt='';
      $ext=file_type($path);
      switch ($path) 
      {
         case 'php'&&'inc':
            {
               $rt='PHP';
            }
            break;
         case 'js':
            {
               $rt='JS';
            }
            break;
         case 'css':
            {
               $rt='CSS';
            }
            break;
         case 'html'&&'htm':
            {
               $rt='HTML';
            }
            break;      
         default:
            $rt='UNKNOWN';
            break;
            return $rt;
      }
   }
}
//function for getting detail about a file
function detail($path)
{
   if (file_exists($path)) 
   {
   	  $detail=array();
   	  $stat=stat($path);
      //file's last access time
      $detail['atime']=date('d-m-Y', $stat['atime']);
      //file's last modification time
      $detail['mtime']=date('d-m-Y', $stat['mtime']); 
      //file size
      $detail['size']=$stat['size'];
      return $detail;
   } 
}
//function for classified view 
function classidiedView($path)
{
       if (file_exists($path)) 
       {
             

       }
}            
        
         







