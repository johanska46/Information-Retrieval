
<?php
include "koneksi.php";
include "IR.php";
require_once 'cosinesimilarity.php';
$cs = new cosinesimilarity();
$ir = new IR();
$jumlahdatatraining=0;
$doc_training = array();
// document yang sebagai percobaan
$result = mysqli_query($conn, "SELECT * FROM training");
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
$data = mysqli_query($conn, "SELECT id_doc FROM training order by id_doc");
?>
<!-- <table  border='1' >;
	<tr>
		<th>No</th>
		<th>id_doc</th>
		<th>term</th>
		<th>TF</th>
		<th>IDF</th>
	</tr>
	-->	<?php 
	$id=0;
	$nomor=1;
	// while ($row1=mysqli_fetch_array($data)) {
		# code...

		// $dokumen = mysqli_query($conn, "SELECT * FROM datatraining where id_doc= '$id' group by term ");
		// while ($row=mysqli_fetch_array($dokumen)) 
		// {
	?>
<!-- 			<tr>
				<td> <?php echo $nomor;?></td>
				<td> <?php echo $row['id_doc'];?></td>
				<td> <?php echo $row['term'];?></td>
				<td> <?php echo $ir->count($row['term'],$row['id_doc']);?></td>
				<td> <?php echo log(($jumlahdatatraining / $ir->count($row['term'],$row['id_doc'])+1)); ?></td>
				
			</tr>
			-->			<?php
			
	// 		$nomor++;
	// 	}
	// 	$id++;
	// }

			?>
		</table>

		<?php
		$vektorq = array();
		$cosine = array();
		$id=0;
		$nomor=1;
		$index_vector=0; 
		$nomorarray=0;
// echo "<br>";
// echo "list data uji :<BR>";
		$ir->datauji();
		echo "<h1>cossine Similarity :</h1><br>";
		$data = mysqli_query($conn, "SELECT id_doc FROM training order by id_doc");
		$uji = mysqli_query($conn, "SELECT * FROM data_uji");

		echo "document uji : ".$dataQ;
		$jumlahkataq=0;
		while ($uji_row=mysqli_fetch_array($uji)) {
			$vektorq[$uji_row['term_uji']] = log(($jumlahdatatraining/$ir->count2($uji_row['term_uji']))+1 );
			$jumlahkataq++;
		}

		while ($row1=mysqli_fetch_array($data)) {
			$dokumen = mysqli_query($conn, "SELECT * FROM datatraining where id_doc= '$id' group by term ");
			$vektord=array();
			$jumlahkatad=0;
			while ($row=mysqli_fetch_array($dokumen)) 
			{
				$vektord[$row['term']]= log(($jumlahdatatraining / $ir->count($row['term'],$row['id_doc'])+1));
				$jumlahkatad++;
			}

			$result1 = $cs->similarity($vektord,$vektorq);
	//echo "<br>cossine Similarity dokumen ".$nomorarray." :".$result1."<br>";
			$cosine[$id] =array($row1['id_doc'] => $result1); 
			$nomorarray++;
			$id++;
		}
//print_r($cosine);
		?>
		<table border="1">
			<tr>
				<td>No_doc</td>
				<td>Cossine</td>
				<td>Dosen Pembimbing</td>
			</tr>

			<?php
			foreach ($cosine as $key=>$values) {
				foreach ($values as $key1 => $value1) {
					?>
					<tr>
						<td><?php echo $key1; ?></td>
						<td><?php echo $value1; ?> </td>
						<td><?php 

						$sql = "SELECT t.dosen_pembimbing,d.nama_dosen from training as t,dosen_pembimbing as d where t.dosen_pembimbing = d.id_dosenP and id_doc= $key1 ";
						$dospem= mysqli_query($conn,$sql);
						while ($row=mysqli_fetch_array($dospem)) {
							echo $row['nama_dosen']; 
						}


						?></td>

					</tr>
					<?php
				}
			}
			?>




		</table>
		<br>
		Tabel Probabilitas dosen Pembimbing:
		<table border="1">
			<tr>
				<td>No_doc</td>
				<td>Dosen Pembimbing</td>
				<td>Probabilitas_doc</td>
				<td>Tingkat_probabilitas</td>
			</tr>

			<?php
	//TIngkat probabilitas dosen
			$nmadospem='';
			$jml_dospem=0;
			$prob_doc =0;
			$prob_dosen=0;
			$arrayprobdospem=array();
			$sql=" TRUNCATE `nbc`.`temp` ";
			$clear=mysqli_query($conn,$sql);
			if ($clear) {
		# code...
				echo "clearing data";
			}else{
				echo "clearing data fail";
			}
			foreach ($cosine as $key=>$values) {
				foreach ($values as $key1 => $value1) {
					?>
					<tr>
						<td>
							<?php echo $key1; ?>
						</td>
			<!-- 	<td>
					<?php echo $value1; ?> 
				</td> -->
				<td>
					<?php 
					$sql = "SELECT dosen_pembimbing from training where id_doc= $key1 ";
					$dospem= mysqli_query($conn,$sql);
					while ($row=mysqli_fetch_array($dospem)) {
						echo $row['dosen_pembimbing'];
						$nmadospem=$row['dosen_pembimbing'];
					}
					?>
				</td>

				<td>
					<?php
					$sql = "SELECT count(dosen_pembimbing) as jumlah from training where dosen_pembimbing= $nmadospem group by dosen_pembimbing ";
					$dospem= mysqli_query($conn,$sql);
					while ($row=mysqli_fetch_array($dospem)) {
						$prob_doc= $value1 / ($value1 + $row['jumlah']);
						echo $prob_doc;
					}
					?>

				</td>
				<td>
					<?php
					$sql = "SELECT count(dosen_pembimbing) as jumlah from training where dosen_pembimbing= $nmadospem group by dosen_pembimbing ";
					$dospem= mysqli_query($conn,$sql);
					while ($row=mysqli_fetch_array($dospem)) {
						$prob_dosen=$row['jumlah']/$jumlahdatatraining;
						echo $prob_dosen;

					}
					?>
					
				</td>
				
				<?php 
				//kalkulasi di masukan di temp
				$sql = "INSERT INTO `temp` (`no`, `dospem`, `prob`, `prob_dosen`) VALUES (NULL, '$nmadospem',  $prob_doc, $prob_dosen)";
				$result = mysqli_query($conn, $sql);
				?>		

			</tr>
			<?php
		}
	}
	?>
</table>
<br>
<h1>NBC Dosen Pembimbing:</h1>
<?php

$NBC = array();
$sql=" TRUNCATE `nbc`.`nbc_dospem_temp` ";
$clear=mysqli_query($conn,$sql);
$sql = "SELECT dospem from temp group by dospem";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
	$prob_nbc=0;
	$prob_nbc_dosen = 0;
	$sql1 = "SELECT prob from temp where dospem = '".$row['dospem']."'";
	//echo "Dosen : ".$row['dospem']."<br>";
	$result1 = mysqli_query($conn, $sql1);
	while ($row1=mysqli_fetch_array($result1)) {
		
		$prob_nbc = $prob_nbc + $row1['prob']; 
		//echo "Prob : ".$prob_nbc."<br>";
	}

	$sql2 = "SELECT prob_dosen from temp where dospem ='".$row['dospem']."' group by dospem";
	$result2 = mysqli_query($conn, $sql2);
	while ($row1=mysqli_fetch_array($result2)) {
		$prob_nbc_dosen = $row1['prob_dosen']; 
	}
	//echo "Prob dosen". $prob_nbc_dosen."<br>" ;
	//$NBC[$row['dospem']]= $prob_nbc+$prob_nbc_dosen;
	$nbc_cal=$prob_nbc+$prob_nbc_dosen;
	////////////
	$sql3 ="INSERT INTO `nbc_dospem_temp` (`nomor`, `id_dosen`, `nbc`) VALUES (NULL, '".$row['dospem']."', '".$nbc_cal."')";
	$result3 = mysqli_query($conn, $sql3);
}
//print_r($NBC);
?>

<?php
$result1 = mysqli_query($conn, "SELECT * FROM doc_uji");
while ($row=mysqli_fetch_array($result1))
{
	echo "document uji : <br>".$row['judul']."<br>";
}
?>
<table border="1">
	<tr>
		<td>
			Rangking
		</td>
		<td>
			Nama dosen pembimbing
		</td>
		<td>
			probabilitas
		</td>
	</tr>
	<?php
	$nomor=1;
	// ksort($NBC);
	$sql = "SELECT * from nbc_dospem_temp as d, dosen_pembimbing as p    where p.id_dosenP = d.id_dosen ORDER BY d.nbc DESC";
	$result = mysqli_query($conn, $sql);
	while ($row=mysqli_fetch_array($result)) {
		?>
		<tr>
			<td><?php echo $nomor;?></td>
			<td><?php echo $row['nama_dosen'];?></td>
			<td><?php echo $row['nbc'];?></td>
		</tr>

		<?php
		$nomor++;
	}

	?>
</table>