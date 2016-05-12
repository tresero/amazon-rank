<?php
//require_once __DIR__ . '/libs/Db.class.php';
require __DIR__ . '/libs/application.php';

class AmazonStats
{
    // I don't care about india or China
//  public $region = array("com","es","ca","de","fr","co.uk","com.br","co.jp","it");
  public $region = array("com","ca","de","co.uk");  
  private $buffer;
  private $amazon;
  public $db;
  private $public_key     = "";
  private $private_key    = "";
  private $associate_tag  = "something-20";


  public function __construct()
  {
    $this->db = new dB();
  }
  public function getASINData()
  {
    $result = $this->db->column("select ISBN from product");
    foreach ($result as $value) {
        if (strlen($value) == 10) {
        $single = array(
		      'Operation' => 'ItemLookup',
		      'ItemId' =>     trim($value),
		      'Category' => 'KindleStore',
		      'ResponseGroup' => 'Medium'
		      );
           sleep(1);

           $numRegions = count($this->region);
           for ($cnt=0;$cnt<$numRegions;$cnt++) {
             $this->getResults($this->region[$cnt],$single);
          } // end for
        } // end if strlen
    } // end foreach

  }

  public function getResults($region,&$single) {
    try
      {
       $result =  aws_signed_request($region, $single, $this->public_key, $this->private_key, $this->associate_tag);
      }
    catch(Exception $e)
      {
	echo $e->getMessage();
	echo "<p />";
        die();
      }
    
    $products = $result->Items->Item;
    
    if (empty($products)) {
      return;
    }
    
    foreach($products as $si){
      // lets get them all!
      $rank = $si->SalesRank;
      if ($rank == '') {
         $rank = 0;
      };
     
      $title = $si->ItemAttributes->Title;
//      echo $title . ' ' . $rank . ' ' . $region . ' ' . $this->single[Category] . '\n';
//      echo $title . ' ' . $rank . ' ' . $region .  "\n";
      //write to db
//      $this->db->bind("title","$title");
        $insert = $this->db->query("INSERT INTO book_rank (asin, rank, region, category) 
               VALUES ('$single[ItemId]', '$rank','$region','$single[Category]')");
      
      if($insert > 0 ) {
	return;
	      } // end if
	     
    } // end foreach
  } // end function
}


$stats= new AmazonStats;
$stats->getASINData();
