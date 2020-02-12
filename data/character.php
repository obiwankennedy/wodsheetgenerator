<?php


class Character
{
    private $fields;
    private $id;
    private $discipline;
    private $atout;
    private $name;
    private $spec;
	private $secret;
	
    private $countSpec;
    private $countAtout;
    private $countDiscipline;
    private $renom;
 
   function Character($line)
    {
      $this->fields = $line;
//       print_r($line);
      $this->name =  $line['ig_name'];
      $this->id =  $line['id'];


        $this->countSpec=0;
        $this->countAtout=0;
       $this->countDiscipline=0;
	$this->secret = false;

    }
	function setSecret($se)
	{
		$this->secret = $se;
	}
    function setAtout($atout)
    {
        $this->atout = $atout;
    }
    function setDiscipline($discipline)
    {

        $this->discipline = $discipline;
    }
    function getDiscipline($j)
    {

        if($i < count($this->discipline))
        {   
            return $this->discipline[$j];
        }
        else
            return "";

    }
    function getField($name)
    {
        return $this->fields[$name];
     }

    function setField($name,$value)
    {
        $this->fields[$name] = $value;
    }
    function setSpec($spec)
    {
        $this->spec=$spec;
     }
    function getSpec($i)
    {
        if($i < count($this->spec))
        {   
            return $this->spec[$i];
        }
        else
            return "";
    }
    function getAtout($i)
    {
       // if($i < count($this->atout))
       // {   
            return $this->atout[$i];
        //}
        //else
          //  return "";
    }

    function getAtoutByNumber($i)
        {
               $j=0;
              foreach($this->atout as $key => $line)
              {
                    
                    if($i==$j)
                    {
                        $line['key']=$key;
                        return $line;
                    }

                    $j++;
              }
              return "";
        }
    function buildRenom($dsql)
	{
        //echo 'buildRenom'.$this->type;
		/*if($this->type==4)
		{*/
           // echo 'buildRenom if';
			$res=$dsql->sendRequest2('select * from lg_renomme inner join char2power on id_pow=id where id_char='.$this->id);
			while($dsql->res_tab_assoc2($line,$res))
			{
                //echo 'buildRenom while';
				$this->renom[$line['id']]=$line;			
			}
		//}

	}
    function getRenom($i)
    {
        //echo $this->renom[$i];
      return $this->renom[$i];
    }

    function getCountSpec()
    {
        return  $this->countSpec;
    }
    function getCountAtout()
    {
        return  $this->countAtout;
    }
    function getCountDiscipline()
    {
        return  $this->countDiscipline;
    }

    function updateModications($dsql)
    {

        /**gets all atouts*/
            $rel = $dsql->sendRequest2('select name,value from atout as a JOIN atout2character as c ON a.id = c.id_atout where c.id_char='.$this->id);
            $this->atout = array();
            while($dsql->res_tab_assoc2($atoutLine,$rel))
            {
			
				$pos = strpos($atoutLine['name'],':');
				if($pos===false)
				{
					$this->atout[$atoutLine['name']] = array($atoutLine['value']);
				}
				else
				{
					
					$newtruc=array('name'=>substr($atoutLine['name'],0,$pos));
					$newtruc['value']=array('name'=>substr($atoutLine['name'],$pos,strpos($atoutLine['name'],':',$pos)));
					$this->atout[$atoutline['name']] = $newtruc;
				}
				
					$this->countAtout++;
            }
           


			
        /**gets all disciplines*/
            $rel2 = $dsql->sendRequest2('select name,value from discipline as a JOIN discipline2character as c ON a.id = c.id_discipline where c.id_char='.$this->id);
            
            $this->discipline = array();
            while($dsql->res_tab_assoc2($disciplineLine,$rel2))
            {
				
                $this->discipline[] = $disciplineLine;
                $this->countDiscipline++;
            }

            
        /**gets all specialisations*/
           $rel3 = $dsql->sendRequest2('select talent,name from specialisation as a JOIN spec2char as c ON c.id_spec = a.id where c.id_character='.$this->id);
            $this->spec = array();
            while($dsql->res_tab_assoc2($specLine,$rel3))
            {
                $this->spec[] = $specLine;
                $this->countSpec++;
            }




        /**gets all  modificators*/
           $relXp = $dsql->sendRequest2('select max(cost) as value ,max(level) as level,attribution,max(type) as type from depensexp where approved=true and id_character='.$this->id.' '.(!$this->secret?'and secret=false':'').' group by attribution');
        //type: 0 => attribut, 1=> compétences, 2 =>spécialités, 3 => Discipline clanique/lignée, 4=> Autres Disciplines,5 => Rituel,6 => Atout, 7=>Puissance du sang,8 => Humanité
        //9 => volonte
            //$Xp = array();
		
            while($dsql->res_tab_assoc2($xpLine,$relXp))
            {
			

                //$userList[$i]->setSpec($spec);
				switch($xpLine['type'])
				{
					case 0://attribut
					case 1://compétences	
						 $this->setField($xpLine['attribution'],$xpLine['level']);
					break;
					case 2://specialités
						$tab=explode(':',$xpLine['attribution']);
						$this->spec[]=array('talent'=>$tab[0],'name'=>$tab[1]);
						$this->countSpec++;
					break;
				
					case 3://Discipline Clanique
					case 4://Autre Discipline
						$added = false;
                        $spec="";
                        if(strpos($xpLine['attribution'],':')===false)
                        {
                              

                        }
                        else
                        {
                            $tabl=explode(':',$xpLine['attribution']);
                            $xpLine['attribution']= $tabl[0];
                            $spec = $tabl[1];
                        }
						foreach($this->discipline as &$discipline)
						{   
							if($discipline['name']==$xpLine['attribution'])
							{
								$discipline['value'] = $xpLine['level'];
                                $discipline['spec'] = $spec;
								$added = true;
							}
						}
						if(!$added)
						{
                            $this->discipline[] = array('name'=>$xpLine['attribution'],'value'=>$xpLine['level'],'spec'=>$spec);
							$this->countDiscipline++;
						}

					break;
					case 5://Rituel

					break;
					case 6://atout	
						$added = false;
						$pos = strpos($xpLine['attribution'],':');


						if($pos===false)
						{
							$this->atout[$xpLine['attribution']][0]=$xpLine['level'];
						}
						else
						{
							$currentAtout=substr($xpLine['attribution'],0,$pos);
							$currentValue=substr($xpLine['attribution'],$pos+1);
						//	echo ' deded ',$currentAtout,'<br/>';
							//$valuetab = $this->atout[$currentAtout];
							
							/*if(is_array($this->atout[$currentAtout]))
							{
								$this->atout[$currentAtout][] = array('name'=>$currentValue,'value'=>$xpLine['level']);
							}
							else	
							{*/
								$this->atout[$currentAtout][]=array('name'=>$currentValue,'value'=>$xpLine['level']);
							//}
						}
							
						if(!$added)
						{
							//print_r($this->atout[$xpLine['attribution']]['value']);
							//$this->atout[$xpLine['attribution']]['value']=$xpLine['level'];	
						}
						 $this->countAtout++;
					break;
						
					case 7://puissance de sang
						
					break;
					case 8://humanité
					break;
				}
			}
				/*echo '<pre>';
				print_r($this->atout);
				echo '</pre>';*/
        }


			







}

?>
