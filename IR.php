<?php

/*
* Information Retrievel

*/

define("DOC_ID", 0);
define("TERM_POSITION", 1);

class IR {

		//parent::__construct();
	//data Training :
	public $num_docs = 0;
	public $corpus_terms = array();
	public $doc = array();
	//data uji :
	public $num_docs1 = 0;
	public $corpus_terms1 = array();
	public $doc1 = array();
	public $doc_uji=array();

	function show_docs($doc) {
		$jumlah_doc = count($doc);
		for($i=0; $i < $jumlah_doc; $i++) {
			echo "Dokumen ke-$i : $doc[$i] <br>";
		}
	}


/*
* Membuat  Index
*/
function create_index($D) {

	$this->num_docs = count($D);
	for($doc_num=0; $doc_num < $this->num_docs; $doc_num++) {

		$doc_terms = array();
// simplified word tokenization process
		$doc_terms = explode(" ", $D[$doc_num]);
		$num_terms = count($doc_terms);
		for($term_position=0; $term_position < $num_terms; $term_position++) {
			$term = strtolower($doc_terms[$term_position]);
			$this->corpus_terms[$term][]=array($doc_num, $term_position);
		}
	}
}
function index_datauji($Q){

	// public $num_docs1 = 0;
	// public $corpus_terms1 = array();
	// public $doc1 = array();

	$this->num_docs1 = count($Q);
	for($doc_num1=0; $doc_num1 < $this->num_docs1; $doc_num1++) {

		$doc_terms1 = array();
	// simplified word tokenization process
		$doc_terms1 = explode(" ", $Q[$doc_num1]);
		$num_terms1 = count($doc_terms1);
		for($term_position1=0; $term_position1 < $num_terms1; $term_position1++) {
			$term1 = strtolower($doc_terms1[$term_position1]);
			$this->corpus_terms1[$term1][]=array($doc_num1, $term_position1);
		}
	}

}

/*
* Show Index
*
*/

public function insert_index(){
	include 'koneksi.php';
	ksort($this->corpus_terms);
	foreach($this->corpus_terms AS $term => $doc_locations) {
		// echo "<b>$term:</b><br>";
		foreach($doc_locations AS $doc_location){
			// echo "[".$doc_location[DOC_ID].", ".$doc_location[TERM_POSITION]."] ";


			$cari = mysqli_query($conn, "SELECT * FROM datatraining where id_doc='".$doc_location[DOC_ID]."' and term='".$term."' and loc='".$doc_location[TERM_POSITION]."' ");
			$num = mysqli_num_rows($cari);

			if ($num < 1) {

					//STEMMING

					//LISTR

				# code...
				$sql = "INSERT INTO `datatraining` (`no`, `id_doc`, `term`,`loc`) VALUES (NULL, '".$doc_location[DOC_ID]."', '".$term."',".$doc_location[TERM_POSITION].")";
				$result = mysqli_query($conn, $sql);
			}
			// echo "| dokumen id : ".$doc_location[DOC_ID]." | dokumen loc  ".$doc_location[TERM_POSITION]." <br>";
		}
		

	}
}


public function datauji() {
	include 'koneksi.php';
	ksort($this->corpus_terms1);
	foreach($this->corpus_terms1 AS $term1 => $doc_locations1) {
		// echo "<b>$term1:</b><br>";
		foreach($doc_locations1 AS $doc_location1){
		// 	// echo "[".$doc_location[DOC_ID].", ".$doc_location[TERM_POSITION]."] ".count($doc_locations);
		// 	$doc_uji = array($term1 => count($doc_locations1));
		// 	// echo  " [ dokumen id :".$doc_location1[DOC_ID]."jumlah :".count($doc_locations1)."] <br>";
		// var_dump($doc_uji);

			$cari = mysqli_query($conn, "SELECT * FROM data_uji where id_uji='".$doc_location1[DOC_ID]."' and term_uji='".$term1."' and loc_uji='".$doc_location1[TERM_POSITION]."' ");
			$num = mysqli_num_rows($cari);

			if ($num < 1) {
				# code...
				$sql = "INSERT INTO `data_uji` (`no_docuji`, `id_uji`, `term_uji`,`loc_uji`) VALUES (NULL, '".$doc_location1[DOC_ID]."', '".$term1."',".$doc_location1[TERM_POSITION].")";
				$result = mysqli_query($conn, $sql);
			}
		}
		
	}
	
}

public function show_index() {
	
	ksort($this->corpus_terms);
	foreach($this->corpus_terms AS $term => $doc_locations) {
		echo "<b>$term:</b><br>";
		foreach($doc_locations AS $doc_location)
			// echo "[".$doc_location[DOC_ID].", ".$doc_location[TERM_POSITION]."] ".count($doc_locations);
			
			echo  " [ dokumen id :".$doc_location[DOC_ID]."jumlah :".count($doc_locations)."] <br>";

		echo "<br />";
	}
	
}
//TF db
function count($term,$id){
	include "koneksi.php";
	$query = mysqli_query($conn, "SELECT * FROM datatraining where term ='".$term."' AND id_doc='".$id."'");
	return mysqli_num_rows($query);

}
function count2($term){
	include "koneksi.php";
	$query = mysqli_query($conn, "SELECT * FROM data_uji where term_uji ='".$term."' ");
	return mysqli_num_rows($query);

}


/*
* Menghitung Term Frequency (TF)
*

*/
function tf($term) {
	$term = strtolower($term);
	return count($this->corpus_terms[$term]);
}

/*
* Menghitung Number Documents With
*
*/
function ndw($term) {
	$term = strtolower($term);
	$doc_locations = $this->corpus_terms[$term];
	$num_locations = count($doc_locations);
	$docs_with_term = array();
	for($i=0; $i < $num_locations; $i++){
		//if (isset($docs_with_term[$i])) {
			# code...
		$docs_with_term[$i]++;
		//}
	}
	return count($docs_with_term);
}
function corpus(){
	var_dump($this->corpus_terms);
}

/*
* Menghitung Inverse Document Frequency (IDF)
*
*/
function idf($term) {
	return log($this->num_docs)/ ($this->ndw($term)+1);
}



}

?>