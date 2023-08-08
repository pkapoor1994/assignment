<?php
function tobritish($dt)
{
	$dy=substr($dt,8,2);
	$yr=substr($dt,0,4);
	$mth=substr($dt,5,2);
	$mdocdt=$dy.'/'.$mth.'/'.$yr;
	return $mdocdt;
}
function tocanada($dt)
{
	$dy=substr($dt,0,2);
	$mth=substr($dt,3,2);
	$yr=substr($dt,6,4);
	$mdocdt=$yr.'-'.$mth.'-'.$dy;
	return $mdocdt;
}

function toenglish($xbillamt)
{
	$mbillamt=intval($xbillamt);
	$word=array();
	$tens=array();
	$word[0]=" Zero";
	$word[1]=" One";
	$word[2]=" Two";
	$word[3]=" Three";
	$word[4]=" Four";
	$word[5]=" Five";
	$word[6]=" Six";
	$word[7]=" Seven";
	$word[8]=" Eight";
	$word[9]=" Nine";
	$word[10]=  "Ten";
	$word[11]=" Eleven";
	$word[12]=" Twelve";
	$word[13]=" Thirteen";
	$word[14]=" Fourteen";
	$word[15]=" Fifteen";
	$word[16]=" Sixteen";
	$word[17]=" Seventeen";
	$word[18]=" Eighteen";
	$word[19]=" Nineteen";

	$tens[2]=" Twenty";
	$tens[3]=" Thirty";
	$tens[4]=" Fourty";
	$tens[5]=" Fifty";
	$tens[6]=" Sixty";
	$tens[7]=" Seventy";
	$tens[8]=" Eighty";
	$tens[9]=" Ninty";
	$hundred=" Hundred";
	$thousand=" Thousand";
	$lakhs=" Lakh";
	$crores=" Crores";
	$english="";
	$mlen=strlen($mbillamt);
	$rept=9-$mlen;
	if($rept>0)
	{
		$mbillamt=str_repeat("0",$rept).$mbillamt;
	}

	$one = substr($mbillamt,8, 1);
	$ten = substr($mbillamt,7, 2);
	$hun = substr($mbillamt,6, 1);
	$tho = substr($mbillamt,4, 2);
	$lakh = substr($mbillamt,2, 2);
	$cror = substr($mbillamt,0, 2);

	if($cror>0)
	{
		if($cror>20)
		{
			$num1=substr($cror,0,1)*10;
			$english.=$tens[substr($lakh,0,1)];
			$num2=substr($cror,1,1);
			$english.=$word[$num2].$crores;
		}
		else
		{
			$english.=$word[$cror].$crores;
		}
	}

	if($lakh>0)
	{
		if($lakh>20)
		{
			$num1=substr($lakh,0,1)*10;
			$english.=$tens[substr($lakh,0,1)];
			$num2=substr($lakh,1,1);
			$english.=$word[$num2].$lakhs;
		}
		else
		{
			$english.=$word[intval($lakh)].$lakhs;
		}
	}

	if($tho>0)
	{
		if($tho>20)
		{
			$num1=substr($tho,0,1)*10;
			$english.=$tens[substr($tho,0,1)];
			$num2=substr($tho,1,1);
			$english.=$word[$num2].$thousand;
		}
		else
		{
			$english.=$word[intval($tho)].$thousand;
		}
	}

	if($hun>0)
	{
		$english.=$word[$hun].$hundred;
	}



	if($ten>0)
	{
		if($ten>19)
		{
			$num1=substr($ten,0,1)*10;
			$english.=$tens[substr($ten,0,1)];
			$num2=substr($ten,1,1);
			$english.=$word[$num2];
		}
		else
		{
			$english.=$word[$ten];
		}
	}

	return $english." Only";
}


function tointeng($xbillamt)
{
	$mbillamt=intval($xbillamt);
	$mdiff=intval(($xbillamt-$mbillamt)*100);

	$word=array();
	$tens=array();
	$word[0]=" Zero";
	$word[1]=" One";
	$word[2]=" Two";
	$word[3]=" Three";
	$word[4]=" Four";
	$word[5]=" Five";
	$word[6]=" Six";
	$word[7]=" Seven";
	$word[8]=" Eight";
	$word[9]=" Nine";
	$word[10]=  "Ten";
	$word[11]=" Eleven";
	$word[12]=" Twelve";
	$word[13]=" Thirteen";
	$word[14]=" Fourteen";
	$word[15]=" Fifteen";
	$word[16]=" Sixteen";
	$word[17]=" Seventeen";
	$word[18]=" Eighteen";
	$word[19]=" Nineteen";

	$tens[2]=" Twenty";
	$tens[3]=" Thirty";
	$tens[4]=" Fourty";
	$tens[5]=" Fifty";
	$tens[6]=" Sixty";
	$tens[7]=" Seventy";
	$tens[8]=" Eighty";
	$tens[9]=" Ninty";
	$hundred=" Hundred";
	$thousand=" Thousand";
	$million=" Million";
	$billion=" Billion";
	$english="";
	$mlen=strlen($mbillamt);
	$rept=9-$mlen;
	if($rept>0)
	{
		$mbillamt=str_repeat("0",$rept).$mbillamt;
	}
	$one = substr($mbillamt,8, 1);
	$ten = substr($mbillamt,7, 2);
	$hun = substr($mbillamt,6, 1);
	$thou = substr($mbillamt,3, 3);
	$mill = substr($mbillamt,0, 3);
	
	if($mill>0)
	{
		if(strlen($mill)>=3)
		{
			if(substr($mill,0,1)>0)
			{
				$english.=$word[substr($mill,0,1)].$hundred;
			}

			if(substr($mill,1,2)>20)
			{
				$num1=substr($mill,1,1)*10;
				$english.=$tens[substr($mill,1,1)];
				$num2=substr($mill,2,1);
				$english.=$word[$num2].$million;
			}
			else
			{
				
				$english.=$word[intval(substr($mill,1,2))].$million;
			}

		}
		else
		{
			if($mill>20)
			{
				$num1=substr($mill,0,1)*10;
				
				$english.=$tens[substr($mill,0,1)];
				$num2=substr($mill,1,1);
				$english.=$word[$num2].$million;
			}
			else
			{
				$english.=$word[$mill].$million;
			}
		}
	}

	
	if($thou>0)
	{
		if(strlen($thou)>=3)
		{
			if(substr($thou,0,1)>0)
			{
				$english.=$word[substr($thou,0,1)].$hundred;
			}

			if(substr($thou,1,2)>20)
			{
				$num1=substr($thou,1,1)*10;
				$english.=$tens[substr($thou,1,1)];
				$num2=substr($thou,2,1);
				$english.=$word[$num2].$thousand;
			}
			else
			{
				
				$english.=$word[intval(substr($thou,1,2))].$thousand;
			}

		}
		else
		{
			if($thou>20)
			{
				$num1=substr($thou,0,1)*10;
				
				$english.=$tens[substr($thou,0,1)];

				$num2=substr($thou,1,1);
				$english.=$word[$num2].$thousand;
			}
			else
			{
				$english.=$word[$thou].$thousand;
			}
		}
	}


	if($hun>0)
	{
		$english.=$word[$hun].$hundred;
	}



	if($ten>0)
	{
		if($ten>19)
		{
			$num1=substr($ten,0,1)*10;
			$english.=$tens[substr($ten,0,1)];
			$num2=substr($ten,1,1);
			$english.=$word[$num2];
		}
		else
		{
			$english.=$word[$ten];
		}
	}

	$english.=" Dirham";

	//after decimel value
	if($mdiff>0)
	{
		$english.=" and";
		if($mdiff>19)
		{
			$num1=substr($mdiff,0,1)*10;
			$english.=$tens[substr($mdiff,0,1)];
			$num2=substr($mdiff,1,1);
			if($num2>0)
			{
				$english.=$word[$num2]." Filis.";
			}	
			else
			{
				$english.=" Filis ";
			}
		}
		else
		{
			$english.=$word[$mdiff]." Filis.";
		}
	}

	return $english." Only";
}

?>


           