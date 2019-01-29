
<?php
include "koneksi.php";
include "IR.php";
require_once 'cosinesimilarity.php';
$cs = new cosinesimilarity();
$ir = new IR();
$jumlahdatatraining=0;
$doc_training = array();
// document yang sebagai percobaan
$result = mysqli_query($conn, "SELECT * FROM training limit 5");
$index=0;
$D=array();

while ($row=mysqli_fetch_array($result))
{
	$jumlahdatatraining++;
	$D[$index]=$row['abstraksi'];
	$index++;
}

$sql=" TRUNCATE `nbc`.`data_uji` ";
$clear=mysqli_query($conn,$sql);
$result1 = mysqli_query($conn, "SELECT * FROM doc_uji where no_doc_uji = '1' ");
$index=0;
$Q=array();
$dataQ="";

while ($row=mysqli_fetch_array($result1))
{
	$dataQ =$row['judul'];
	$Q[$index]=$row['judul'];
	$index++;
}

//data training insert 
echo "<p><b>Corpus:</b></p>";
$ir->show_docs($D);
$ir->create_index($D);
$ir->index_datauji($Q);
//echo "<p><b>List Index:</b></p>";
$ir->insert_index();
//data insert
$data = mysqli_query($conn, "SELECT id_doc FROM training order by id_doc limit 5");
?>
<table  border='1' >;
	<tr>
		<th>No</th>
		<th>id_doc</th>
		<th>term</th>
		<th>TF</th>
		<th>IDF</th>
		<th>prodi</th>
	</tr>
	<?php 
	$id=0;
	$nomor=1;
	while ($row1=mysqli_fetch_array($data)) {
		

		$dokumen = mysqli_query($conn, "SELECT * FROM datatraining where id_doc= '$id' group by term  ");
		while ($row=mysqli_fetch_array($dokumen)) 
		{
			?>
			<tr>
				<td> <?php echo $nomor;?></td>
				<td> <?php echo $row['id_doc'];?></td>
				<td> <?php echo $row['term'];?></td>
				<td> <?php echo $ir->count($row['term'],$row['id_doc']);?></td>
				<td> <?php echo log(($jumlahdatatraining / $ir->count($row['term'],$row['id_doc'])+1)); ?></td>
				<td> <?php echo $row['prodi']; ?></td>
				
			</tr>
			<?php
			
			$nomor++;
		}
		$id++;
	}

	?>
</table>
