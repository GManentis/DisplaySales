<?php

class sales_class
{
	private $CONNPDO;
	private $days;
	private $counts;
	private $cost;
	private $profit;
	public $results;
	public $results2;
	
	
	public function __construct(PDO $pdo, $days) 
	{
        $this->CONNPDO = $pdo;
		$this->setDays($days);
    }

	
	public function getDays()
	{
		return $this->days;
		
	}
	
	public function setDays($x)
	{
		if(preg_match('/^\d+$/', $x)) 
		{
			$this->days = $x;
		}
		else
		{
			echo "Invalid entry.Τhe entries shall be considered 0<br><br>";
			$this->days = 0;
		}
		
	}
	
	public function getTransactions()
	{
		$getdata_PRST = $this->CONNPDO->prepare("SELECT * FROM agency WHERE day = :day ");
		$getdata_PRST -> bindValue(":day", $this->getDays());
		$getdata_PRST -> execute() or die($CONNPDO->errorInfo());
		$this->counts = $getdata_PRST->rowCount();
		
			if($this->counts > 0)	
			{
				$results = "<h4>For Day ".$this->getDays()."</h4><br><br><table class='table'><th>Passengers Package</th><th>Transactions</th>";
				
				while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
				{
					$results .= "<tr><td>".$getdata_RSLT["passengers"]."</td><td>".$getdata_RSLT["transactions"]."</td></tr>";
				}
				
				$results .="</table><br><br><br>";
				
				$this->results1 = $results;
				
			}
			else
			{
				$this->results1 = "No entry for this day was found ".$this->getDays();
			}
		
		return $this->results1;
	}
	
	public function calculateResults()
	{
		$getdata_PRST = $this->CONNPDO->prepare("SELECT * FROM agency WHERE day = :day ");
		$getdata_PRST -> bindValue(":day", $this->days);
		$getdata_PRST -> execute() or die($CONNPDO->errorInfo());
		$this->counts = $getdata_PRST->rowCount();
		
			if($this->counts > 0)	
			{
				$results = "<h4>OTA Results For Day ".$this->getDays()."</h4>";
				
				while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
				{
					(int)$transactions = $getdata_RSLT["transactions"];
					(int)$passengers = $getdata_RSLT["passengers"];
					$this->cost += $transactions * $passengers * 100;
					$this->profit += $transactions * $passengers * 103 - $transactions*5 ;
				}
					

				$total = $this->profit - $this->cost;
				$this->results2 = "<h4>This day's profits are: ".$total."</h4>";
				
				
			}
			else
			{
				$this->results2 = "No entry for this day was found";
			}
		
		return $this->results2;
	}
	
	

	
}
?>