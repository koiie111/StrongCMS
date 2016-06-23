<?php
//Author: [J]iK
class navig{
public $start = 0;
public $count = 0;
public $nstr= 0;
public $page = 0;
public $total_p= 0;
function __construct($sql,$nstr=0){
global $db,$user,$_SERVER;
$count=$db->query($sql)->num_rows;
$user['maxel']=(empty($user['maxel'])?'10':$user['maxel']);
$nstr=($nstr==0)?$user['maxel']:$nstr;
$nstr=($nstr==null)?'10':$nstr;
@$page=($_GET['page']=='last')?$count:abs(intval($_GET['page']));
$this->total_p=($count>0)?ceil($count/$nstr):'1';
$page=($page<1)?'1':$page;
$this->count=$count;
$this->nstr=$nstr;
$this->page=($this->total_p >= $page)?$page:$this->total_p;
$this->start = $nstr*$page-$nstr;

}
private function bb($num,$url=null){
$zp=($num == $this->total_p)?null:' ';
if($this->page == $num){return '<navb>'.$num.'</navb>'.$zp;}else{return '<a  href="'.$url.'&page='.$num.'">'.$num.'</a>'.$zp;}}
function panel(){
if($this->total_p > 1 ){
global $_SERVER;
$urlp=explode('?',$_SERVER['REQUEST_URI']);
$url1=explode('&',$urlp[1]);
if(strpos('#'.$_SERVER['REQUEST_URI'],'&page=')>0){
unset($url1[sizeof($url1)-1]);}
$url=$urlp[0].'?'.implode('&',$url1);
$back=null;$cont=null;
if($this->page>1){

$back='<a href="'.$url.'&page='.($this->page-1).'"><</a>';
}
if($this->total_p>=$this->page+1){

$cont='<a href="'.$url.'&page='.($this->page+1).'">></a>';

}
echo '<p>'.$back.$cont.'</p>';
echo'<p>';

$ot=($this->page > 3)?($this->page-2):'1';
$do=($this->total_p > ($this->page+3))?($this->page+2):$this->total_p;
if($this->page >3 ){echo $this->bb('1',$url).'...';}
for($i=$ot; $i<=$do; $i++){
echo $this->bb($i,$url);
}
if($this->total_p > ($this->page+3)){echo '...'.$this->bb($this->total_p,$url);}
echo'</p>';

}
}
}
?>