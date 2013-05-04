<?php
class Trip_model extends Model{

	function Trip_model()
	{
		parent::Model();
	}

	function getTripName($id){

		$this->db->where('ID',$id);
		$this->db->select('TRIPNAME');
		$query=$this->db->get('TRIP');
		return $query->result();
	}

	function getTripMembers($id){
		$this->db->select('MEMBERS.ID,NAME');
		$this->db->from('MEMBERS');
		$this->db->where('Trip_FK',$id);
		//$this->db->join('TRIP','TRIP.ID=MEMBERS.Trip_FK');
		$query=$this->db->get();
		return $query->result();

	}

	function getBillsByMember($trip_id,$member_id){
		//hakee kaikki yhden hemmon laskut (vain summat jne)
		$this->db->where('BILLS.TRIP_FK',$trip_id);
		$this->db->where('MEMBERS_FK',$member_id);
		$query=$this->db->get('BILLS');
		return $query->result();

	}
	
	function getBillsSumByMember($trip_id,$member_id){
		
		//echo $trip_id;
		//echo $member_id;
		$bills=$this->getBillsByMember($trip_id, $member_id);
		$sum=0;
		foreach ($bills as $row){
			
			$sum=$sum+$row->SUM;
			
		}
		
		
		
		return $sum;
		
	}
	
	//taa ei ole turvallinen
	function deleteBill($bill_id){
		$this->db->where('ID',$bill_id);
		$this->db->delete('BILLS');
	}

	function getBillParticipants($bill_id){
		//hakee ketka on osallistunut yhden hemmon laskuun

		$this->db->select('MEMBERS.ID, NAME');
		$this->db->where('BILLS.ID',$bill_id);
		$this->db->from('MEMBERS');
		$this->db->join('BILLS_MEMBERS','BILLS_MEMBERS.MEMBERS_FK=MEMBERS.ID');
		$this->db->join('BILLS','BILLS_MEMBERS.BILLS_FK=BILLS.ID');
		$query=$this->db->get();

		return $query->result();
	}

	function addTrip($name,$members){
		$data=array('TRIPNAME'=>$name);

		$this->db->insert('TRIP', $data);
		$id=$this->db->insert_id();
		//$data2=0;
		//var_dump($members);
		foreach ($members as $row){
			$name=$row['NAME'];
			$email=$row['EMAIL'];
			$account=$row['ACCOUNTNUMBER'];
			$data2=array("NAME" => $name,	"EMAIL"=>$email,"ACCOUNTNUMBER"=>$account,"Trip_FK"=>$id);

			$this->db->insert('MEMBERS',$data2);

		}

		return $id;


	}

	function addMembersToTrip($trip, $members){
		//trip... nimi, email, tilinumero
		//obsolete :)
	}

	function addBillToTrip($trip_id, $member_id, $sum, $description, $participant_ids){
		//alas kirjoittaa poju
		$bill=array(
		'SUM'=>$sum, 
		'DESCRIPTION'=>$description, 
		'MEMBERS_FK'=>$member_id,
		'TRIP_FK'=>$trip_id 
		);

		$this->db->insert('BILLS',$bill);
		$bill_id=$this->db->insert_id();
		foreach ($participant_ids as $row){
			$part_data=array(
			'BILLS_FK'=>$bill_id,
			'MEMBERS_FK'=>$row,
			);
			$this->db->insert('BILLS_MEMBERS', $part_data);
		}



	}

	function calculateTripTransactions($trip){

		//haetaan reissun jasenet
		$members=$this->getTripMembers($trip);

		//eritelmaa varten jasenet
		$member_counter_h=0;
		foreach ($members as $rowZ){
			$member_helper[$rowZ->ID]=$member_counter_h;
			$member_counter_h=$member_counter_h+1;	
		}
		
		//$debt=array();
		//haetaan reissun jasenien laskut
		foreach($members as $row){
			$member_name=$row->NAME;
			$member_id=$row->ID;

			//haetaan henkilon laskut
			$bills=$this->getBillsByMember($trip, $member_id);

			//kasitellaan yksittainen lasku
			foreach($bills as $rowB){

				//jos on jo saatavia/velkoja, niin laitaan maksettu summa
				if(isset($debt) && array_key_exists($member_id, $debt)){

					$debt[$member_id][1]=$debt[$member_id][1]+$rowB->SUM;

				}
				else{

					$debt[$member_id][1]=$rowB->SUM+0;
					$debt[$member_id][0]=$member_name;

				}
				//laskueritelmaa varten maksaja, formaatti bill_id, bill_desc,bill_sum, member_id, member_name
				
				
				//haetaan laskun jasenet
				$parts=$this->getBillParticipants($rowB->ID);
				$parts_count=count($parts);

				//eritelmaa varte
				$member_debt_h=array();
				//taa vali pois, siis ylospain
				
				//vahennetaan jokaiselta niiille kuuluva osuus
				foreach($parts as $row2){
					//paivitetaan debt-taulukon entryja
					if(array_key_exists($row2->ID, $debt)){
						$debt[$row2->ID][1]=$debt[$row2->ID][1]-($rowB->SUM)/$parts_count;
					}
					else{
						$debt[$row2->ID][1]=(-1)*(($rowB->SUM)/$parts_count);
						$debt[$row2->ID][0]=$row2->NAME;
					}
					//tehdaan bill_separation eritelma !!! pois ei nain
					$member_debt_h[$row2->ID]=round((-1)*(($rowB->SUM)/$parts_count),2);
					//taa vali pois, siis ylospain
				}
				//taa rivi pois
				$eritelma=array();
				$eritelma[0]=$member_name;
				$eritelma[1]=$rowB->DESCRIPTION;
				$eritelma[2]=$rowB->SUM;
				//$eritelma[$member_helper[$member_id]+3]=$rowB->SUM;
				foreach($member_debt_h as $key=>$row){
					//if(isset($eritelma[$member_helper[$key]+3])){
					if($member_id==$key){
						//$eritelma[$member_helper[$key]+3]=$eritelma[$member_helper[$key]+3]+$row;
						$eritelma[$member_helper[$key]+3]=$rowB->SUM+$row;
					}
					else{
						$eritelma[$member_helper[$key]+3]=$row;
					}
				}
				$eritelma_final[]=$eritelma;
				//var_dump($eritelma);
					
			}

		} //is for luuppi loppuu, debt-taulukko on valmis
		
		if(!isset($debt)){
			return FALSE;
		}
		//pyoristus
		foreach ($debt as $key =>$row){
			$debt[$key][1]=round($debt[$key][1],2);
		}
		//tää on turha
		/*
		foreach ($debt as $key =>$row){
		
			echo "henkiloID: ".$key." nimi: ".$row[0]." summa: ".$row[1]."  <br>";
		}
		var_dump($bill_separation_final);

		*/
		
		//tahan funktio joka kutsuu laskentaa, joka saa debt-taulukon itselleen
		//logiikka: 1. debt-taulukko: velat ja saatavat
		//for looppi veloista. sisään while looppi saatavista
		//whileä ennen tarkistetaan aina, että onko a. tasasummia B. kahden summa on yhten velka
		//while loopissa maksetaan kaikki yhden tyypin velat pois
		//usort (muutetaan eka). Sortataan eka saajat ja myös velalliset.
		//while-loopissa aina mennään eteenpäin jos summaa on jäljellä (suuruusjärjestyksessä)
		//usort ajetaan aina ennen while-loooppia saajien taulukolle
		
		$debt_transact=$this->calculateTransactionsFromDebt($debt);
		$return_data['debt_transact']=$debt_transact;
		$return_data['eritelma']=$eritelma_final;
		$return_data['members']=$members;
		$return_data['debt']=$debt;
		return $return_data;

		//$data[0]=$bill_separation_final;
		//$data[1]=$debt_transact;
		//return $data;
		


			
	}
	function calculateTransactionsFromDebt($debt){

		//jaetaaan taulukko velallisiin ja saajiin
		foreach($debt as $key3 =>$row3){
			if($debt[$key3][1]>0){
				$debt_get[]=array($debt[$key3][0], $debt[$key3][1]);
			}
			if($debt[$key3][1]<0){
				$debt_pay[]=array($debt[$key3][0], $debt[$key3][1]);
			}
		}

	
		
		usort($debt_pay, array($this,'_compare'));
		
		for ($i=0;$i<count($debt_pay);$i +=1){
			$get_index=count($debt_get)-1;
			usort($debt_get, array($this,'_compare'));
			$isLeft=1;
			
			//tama tarkistaa tasasummat
			
			$even=$this->checkEven($debt_pay,$debt_get);
			
			if($even){
				$isLeft=0;
				$i=$i-1;
				//echo "kukkuu";
				//var_dump($even);
				
				foreach ($even as $x=>$rowf){
					$debt_transact[]=array($debt_pay[$even[$x][0]][0],abs($debt_pay[$even[$x][0]][1]),$debt_get[$even[$x][1]][0]);
					//echo "kuka: ".$debt_pay[$even[$x][0]][0]." paljon: ".$debt_pay[$even[$x][0]][1];
					//echo "kuka: ".$debt_get[$even[$x][1]][0]." paljon: ".$debt_get[$even[$x][1]][1];
					$debt_pay[$even[$x][0]][1]=0;
					$debt_get[$even[$x][1]][1]=0;
				}
			}
			
			//tama tarkistaa onko kahden velka yhden saatava
			$even2sum=$this->check2SumEven($debt_pay,$debt_get);
			
			if($even2sum){
				$isLeft=0;
				$i=$i-1;
				//var_dump($even2sum);
				//echo "kukkuuXX";
				
				foreach ($even2sum as $x=>$rowf){
					//echo "even2sum !!!   ";
					$debt_transact[]=array($debt_pay[$even2sum[$x][0]][0],abs($debt_pay[$even2sum[$x][0]][1]),$debt_get[$even2sum[$x][1]][0]);
					//echo "kuka: ".$debt_pay[$even2sum[$x][0]][0]." paljon: ".$debt_pay[$even2sum[$x][0]][1];
					//echo "kuka: ".$debt_get[$even2sum[$x][1]][0]." paljon: ".$debt_get[$even2sum[$x][1]][1];
					$debt_get[$even2sum[$x][1]][1]=$debt_get[$even2sum[$x][1]][1]+$debt_pay[$even2sum[$x][0]][1];
					$debt_pay[$even2sum[$x][0]][1]=0;
				}
			}
			
			
			if(isset($debt_pay[$i])){
			while ($isLeft==1 && $debt_pay[$i][1]!=0){
				//ei pysty maksaa kokonaan ketaan pois
				//echo abs($debt_pay[$i][1]. " < ".$debt_get[$get_index][1];
				if(abs($debt_pay[$i][1])<$debt_get[$get_index][1]){
					$debt_transact[]=array($debt_pay[$i][0],abs($debt_pay[$i][1]),$debt_get[$get_index][0]);
			
					$debt_get[$get_index][1]=$debt_get[$get_index][1]+$debt_pay[$i][1];
					$debt_pay[$i][1]=0;
					//$get_index=$get_index-1;
					$isLeft=0;
				}
				else{
										
					//if(($debt_get[$get_index][1])!=0){
					$debt_transact[]=array($debt_pay[$i][0],$debt_get[$get_index][1],$debt_get[$get_index][0]);
					//echo "tanne tuli: ".$debt_get[$get_index][1];
					//echo "summa on: ". $debt_pay[$i][1];
					$debt_pay[$i][1]=+$debt_pay[$i][1]+$debt_get[$get_index][1];
					//echo $debt_pay[$i][1];
					$debt_get[$get_index][1]=0;
					$get_index=$get_index-1;

					//}
					if($debt_pay[$i][1]==0 ||$get_index<0 ||$debt_get[$get_index][1]==0){
						$isLeft=0;
					}
				}
			}
			}		
		}
		
		return $debt_transact;

	}

	//ehka pitaa muokkaa viela
	static function _compare($x, $y)
	{
		if ( $x[1] == $y[1] )
		return 0;
		else if ( $x[1] < $y[1] )
		return -1;
		else
		return 1;
	}
	
	function check2SumEven($debt_pay,$debt_get){
		
		//lasketaan kahden henkilon velkojen summa , tasta voisi jo aiemmin poistaa nollat taulukosta array_splicella
		for ($counter=0; $counter<count($debt_pay);$counter +=1){
			for ($counter2=$counter; $counter2<count($debt_pay);$counter2 +=1){
				if($counter!=$counter2){
					if($debt_pay[$counter][1]!=0 && $debt_pay[$counter2][1]!=0){
						$debt_pay_2sum[]=array($debt_pay[$counter][1]+$debt_pay[$counter2][1], $counter, $counter2);
					}
				}
			}
		}
			//jos kahden velkojen summa on yhden saatava, niin se maksetaan pois
		if(isset($debt_pay_2sum)){
			foreach($debt_get as $keyG2=>$rowG2){
				foreach($debt_pay_2sum as $keyG3=>$rowG3){
			
					if(abs($debt_pay_2sum[$keyG3][0])==$debt_get[$keyG2][1]&&abs($debt_pay_2sum[$keyG3][0])!=0&&$debt_get[$keyG2][1]!=0){
										
						$transaction_indexes[]=array($debt_pay_2sum[$keyG3][1],$keyG2);
						$transaction_indexes[]=array($debt_pay_2sum[$keyG3][2],$keyG2);
						$debt_pay_2sum[$keyG3][0]=0;
						$debt_get[$keyG2][1]=0;
						$debt_pay[$debt_pay_2sum[$keyG3][1]][1]=0;
						$debt_pay[$debt_pay_2sum[$keyG3][2]][1]=0;
					/*
					$debt_pay_sum[$keyG3][1]
					$debt_pay_sum[$keyG3][2]
					$debt_pay[$keyP][1]=0;
					$debt_get[$keyG][1]=0;
					
					
					$debt_transact[]=array($debt_pay[$debt_pay_2sum[$keyG3][1]][0],abs($debt_pay[$debt_pay_2sum[$keyG3][1]][1]),$debt_get[$keyG2][0]); 
					$debt_transact[]=array($debt_pay[$debt_pay_2sum[$keyG3][2]][0],abs($debt_pay[$debt_pay_2sum[$keyG3][2]][1]),$debt_get[$keyG2][0]);
					*/ 
					
					
					}
				}
			}
		}

		if(isset($transaction_indexes)){
			return $transaction_indexes;
		}
		else{
			return false;
		}
	}
	
	function checkEven($debt_pay,$debt_get){
		
	 //maksetaan eka pois tasasummat (pitäs unsettaa tai muuta vastaavaa (array_splice, tai sääntö ettei ota summiin mukaan nollia)
		foreach($debt_get as $keyG=>$rowG){
			foreach($debt_pay as $keyP=>$rowP){
					if(abs($debt_pay[$keyP][1])==$debt_get[$keyG][1]&&abs($debt_get[$keyG][1])!=0&&abs($debt_pay[$keyP][1])!=0){
					$transaction_indexes[]=array($keyP, $keyG);
					$debt_pay[$keyP][1]=0;
					$debt_get[$keyG][1]=0;
					
					}
			}
		}
		
		if(isset($transaction_indexes)){
			return $transaction_indexes;
		}
		else{
			return false;
		}


		
	}

}
?>