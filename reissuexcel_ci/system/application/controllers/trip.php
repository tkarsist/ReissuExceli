<?php

class Trip extends Controller {

	function Trip()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('index_view');
	}
	
	function start()
	{
		$this->load->view('create_trip_view');
	}
	
	function createtrip()
	{
		$this->load->model('trip_model');
		
		$count=1;
		
		while ($this->input->post('name_'.$count)!=FALSE){
			
			$name=$this->input->post('name_'.$count);	
			
			/*if($this->input->post('email'.$count)){
				$email=$this->input->post('email'.$count);	
			}
			else{
				$email="";
			}*/
			
			
			$members[]=array("NAME"=>$name, "EMAIL"=>"", "ACCOUNTNUMBER"=>"");
			$count=$count+1;
		}
		
		
		if($this->input->post('tripname')!=FALSE){
			
			$trip_id=$this->trip_model->addTrip($this->input->post('tripname'),$members);
			//tää on se välisivu
			//$data['trip_id']=$trip_id;
			//$this->load->view('trip_created', $data);
			$this->trip_main($trip_id);
			
		}
		
	}	
	
	function trip_main($trip){
		$this->load->model('trip_model');
		$data['trip_name']=$this->trip_model->getTripName($trip);
		$data['members']=$this->trip_model->getTripMembers($trip);
		$data['trip_id']=$trip;
		
		foreach ($data['members'] as $row){
		$member_sums[$row->ID]=$this->trip_model->getBillsSumByMember($trip,$row->ID);
			
		}
		$data['member_sums']=$member_sums;
		
		
		$this->load->view('trip_main_view', $data);

		
		
	}
	
	function trip_cost(){
		
		

		
		$member=$this->input->post('member');
		$membername=$this->input->post('membername');
		$trip=$this->input->post('trip');

		$this->load->model('trip_model');
		
		//syotetaan uusi tapahtuma kantaan
		if($this->input->post('cost') && $this->input->post('participants') && $this->input->post('sum')){
			
			foreach($this->input->post('participants') as $row){
				$parts[]=$row;
			}
			$sum=$this->input->post('sum');
			$desc=$this->input->post('description');
			//echo "osuma";
			//ei tehty viela (modeliin)
			$this->trip_model->addBillToTrip($trip,$member,$sum,$desc,$parts);	
		}
		
		//tuhotaan lasku kannasta
			if($this->input->post('delete')){
			$this->trip_model->deleteBill($this->input->post('bill'));
		}

		//haetaan kannasta kaikki olemassa olevat laskut
		
		
		$data['trip_name']=$this->trip_model->getTripName($trip);
		$data['trip_members']=$this->trip_model->getTripMembers($trip);
		$data['trip_id']=$trip;
		$data['member']=$member;
		$data['membername']=$membername;
		$data['trip']=$trip;
		
		
		
		$data_help=$this->trip_model->getBillsByMember($trip, $member);
		
		
		
		foreach ($data_help as $row){
			unset($partstring);
			
			$participants=$this->trip_model->getBillParticipants($row->ID);
			
			
			foreach ($participants as $row2){
				if(!isset($partstring)){
					$partstring=$row2->NAME;
				}
				else{
				$partstring=$partstring.", ".$row2->NAME;
				}
			}
			$bills[]=array($row->ID, $row->SUM, $row->DESCRIPTION, $partstring);
			
		}
		if(isset($bills)){
			$data['bills']=$bills;
			
		}
		
		$this->load->view('trip_member_cost_view', $data);
				
		
	}
	
	function trip_calculate(){
		
		$this->load->model('trip_model');
		$trip=$this->input->post('trip');
		$data['trip_name']=$this->trip_model->getTripName($trip);
		$calculate_data=$this->trip_model->calculateTripTransactions($trip);
		$data['debt_transact']=$calculate_data['debt_transact'];
		$data['eritelma']=$calculate_data['eritelma'];
		$data['members']=$calculate_data['members'];
		$data['debt']=$calculate_data['debt'];
		
		//tass kutsutaan uutta functiota modellissa, joka tekee samalla tavalla
		//kuin velkataulukko tehdaan. Siis tehdaan velkataulukko kuten leiskassa, jossa
		//on laskukohtaiset summat? Mieti ny viel
		
		
		$this->load->view('transactions_view',$data);
		
	}
	
	function test()
	{
		$this->load->model('trip_model');
		$data['tripname']=$this->trip_model->getTripName('58');
		$data['members']=$this->trip_model->getTripMembers('58');
		$this->load->view('test_view',$data);
	}
	
	function test2()
	{
		$this->load->model('trip_model');
		$data['participants']=$this->trip_model->getBillParticipants('68');
		$data['bills']=$this->trip_model->getBillsByMember('139','68');
		$this->load->view('test2_view',$data);
	}
	function test3()
	{
		$this->load->view('test3_view');
	}
	
	function test4()
	{
		$roska=$this->input->post('user');
		echo $roska;
		//voi siis tehda esim post-kasittelyn ja sitten ohjata takas nakymaan
		//$this->test3();
	}

	function test5()
	{
		$this->load->model('trip_model');
		$arr[]=array("NAME"=>"Jaska", "EMAIL"=>"jaska@jaska", "ACCOUNTNUMBER"=>"11221");
		$arr[]=array("NAME"=>"Paska", "EMAIL"=>"paska@jaska", "ACCOUNTNUMBER"=>"11221");
		$arr[]=array("NAME"=>"Saska", "EMAIL"=>"ssaska@jaska", "ACCOUNTNUMBER"=>"11221");
		$arr[]=array("NAME"=>"HARRI", "EMAIL"=>"", "ACCOUNTNUMBER"=>"");
		$this->trip_model->addTrip("TestireissuX",$arr);
	}
	
	function test6()
	{
		//alempi printtaa urlin, vois laittaa alle sen, etta palauttaa urlin ja ei generoi dataa
		//eli looppi, joka kattoo esim ekat 20 palaa, jos eka pala kohdillaan tai kaks palaa, niin 
		//ei ota randomia vaan vastaa
		//vastaa esim vain transaktioiden maaran
		//echo $this->uri->segment(4, 0);
		
		$this->load->model('trip_model');
		if($this->input->post('generate')){
			$member_count=rand(2,20);
			for ($counter=1; $counter<=$member_count;$counter +=1){
				
				$paid_array[]=array($counter,rand(0,300));
				/*$sign=rand(1,2);
				if($sign==1){
					$debt[]=rand(0,300);
				}
				else{
					$debt[]=rand(0,300)*(-1);
				}
				*/
			}
			
		$i=0;
		$sum=0;
	
		//lasketaan summa
		foreach($paid_array as $key=>$row){
			$i++;	
			$sum=$sum+$paid_array[$key][1];
		}
	
		$sum_avg=$sum/$i;

		foreach($paid_array as $key2=>$row2){

			$debt[]=array($paid_array[$key2][0], $paid_array[$key2][1]-$sum_avg);	
		}
		$saatavat=0;
		$velat=0;
		foreach($debt as $key3=>$row3){
			if($row3[1]>0){
				$saatavat=$saatavat+$row3[1];
			}
			if($row3[1]<0){
				$velat=$velat+$row3[1];
			}
		}
		
		
		$data['debt']=$debt;	
		$data['saatavat']=$saatavat;
		$data['velat']=$velat;
		$data['debt_transact']=$this->trip_model->calculateTransactionsFromDebt($debt);
		$transaktiosumma=0;
		foreach($data['debt_transact'] as $row4){
			$transaktiosumma=$transaktiosumma+$row4[1];
		}
		$data['transaktiosumma']=$transaktiosumma;
		$data['paid_array']=$paid_array;
		$data['sum_avg']=$sum_avg;
		}
		
		


	
		
		if(!isset($data)){
			$this->load->view('test6_view');
		}
		else{
		$this->load->view('test6_view', $data);
		}
	}
	function test7(){
		$this->load->model('trip_model');
		for($i=3;$i<=23;$i++){
			if($this->uri->segment($i)) {
				
				$paid_array[]=array($i-3,intval($this->uri->segment($i)));
								
			}	
			
			
				
		}
			$i=0;
		$sum=0;
	
		//lasketaan summa
		foreach($paid_array as $key=>$row){
			$i++;	
			$sum=$sum+$paid_array[$key][1];
		}
	
		$sum_avg=$sum/$i;

		foreach($paid_array as $key2=>$row2){

			$debt[]=array($paid_array[$key2][0], $paid_array[$key2][1]-$sum_avg);	
		}
		$saatavat=0;
		$velat=0;
		foreach($debt as $key3=>$row3){
			if($row3[1]>0){
				$saatavat=$saatavat+$row3[1];
			}
			if($row3[1]<0){
				$velat=$velat+$row3[1];
			}
		}
		
		

		$debt_transact=$this->trip_model->calculateTransactionsFromDebt($debt);
		echo count($debt_transact);
		
		
		
	}
	
}

?>